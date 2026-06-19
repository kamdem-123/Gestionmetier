<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\DemandeEmployeur;
use App\Models\Offre;
use App\Notifications\DossierRejeteNotification;
use App\Notifications\EntretienProgrammeNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeurController extends Controller
{
    public function __construct()
    {
        // Tous les endpoints vérifient le rôle employeur
    }

    public function index()
    {
        $this->verifierEmployeur();
        $user = Auth::user();

        // Récupère les infos entreprise depuis la demande initiale
        $demande    = DemandeEmployeur::where('email', $user->email)->first();
        $entreprise = $demande?->entreprise ?? $user->name;
        $secteur    = $demande?->secteur ?? '';

        // Offres soumises par cet employeur
        $offres = Offre::with(['entreprise', 'candidatures.user'])
            ->where('posted_by_user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        // Marquer les nouvelles candidatures comme "vue"
        $offres->each(function ($offre) {
            $offre->candidatures
                ->where('statut', Candidature::STATUT_EN_ATTENTE)
                ->each(fn($c) => $c->update(['statut' => Candidature::STATUT_VUE]));
        });

        // Stats
        $totalOffres       = $offres->count();
        $totalCandidatures = $offres->sum(fn($o) => $o->candidatures->count());
        $entretiensAVenir  = Candidature::whereIn('offre_id', $offres->pluck('id'))
            ->where('statut', Candidature::STATUT_ENTRETIEN_PROGRAMME)
            ->where('entretien_date', '>=', now()->toDateString())
            ->count();

        return view('employeur_dashboard', compact(
            'user', 'offres', 'totalOffres', 'totalCandidatures', 'entretiensAVenir',
            'entreprise', 'secteur'
        ));
    }

    /**
     * Endpoint JSON pour le polling temps réel du dashboard employeur.
     */
    public function liveData(): \Illuminate\Http\JsonResponse
    {
        $this->verifierEmployeur();
        $user = Auth::user();

        $offres = Offre::with(['candidatures.user'])
            ->where('posted_by_user_id', $user->id)
            ->get();

        // Marquer les nouvelles candidatures comme vues
        $offres->each(function ($offre) {
            $offre->candidatures
                ->where('statut', Candidature::STATUT_EN_ATTENTE)
                ->each(fn($c) => $c->update(['statut' => Candidature::STATUT_VUE]));
        });

        $data = $offres->map(fn($offre) => [
            'id'    => $offre->id,
            'total' => $offre->candidatures->count(),
            'candidatures' => $offre->candidatures->sortByDesc('score_matching')->values()->map(fn($c) => [
                'id'             => $c->id,
                'nom'            => $c->user?->name ?? '—',
                'email'          => $c->user?->email ?? '',
                'titre_poste'    => $c->user?->titre_poste ?? '',
                'score'          => $c->score_matching ? number_format($c->score_matching, 1) : null,
                'statut'         => $c->statut,
                'statut_libelle' => $c->libelleStatut(),
                'entretien_date' => $c->entretien_date?->format('d/m/Y'),
                'entretien_heure'=> $c->entretien_heure ? substr($c->entretien_heure, 0, 5) : null,
                'peut_agir'      => !in_array($c->statut, ['refusee', 'entretien_programme']),
                'rejeter_url'    => route('employeur.rejeter', $c),
                'entretien_url'  => '/employeur/candidature/' . $c->id . '/entretien',
            ]),
        ]);

        $totalCandidatures = $offres->sum(fn($o) => $o->candidatures->count());

        return response()->json([
            'offres'            => $data,
            'totalCandidatures' => $totalCandidatures,
            'timestamp'         => now()->toIso8601String(),
        ]);
    }

    /**
     * Liste des candidats pour une offre précise.
     */
    public function candidats(Offre $offre)
    {
        $this->verifierEmployeur();
        $this->verifierPropriete($offre);

        $candidatures = $offre->candidatures()
            ->with('user')
            ->orderByDesc('score_matching')
            ->get();

        // Marquer les nouvelles candidatures comme "vue"
        $candidatures->where('statut', Candidature::STATUT_EN_ATTENTE)
            ->each(fn($c) => $c->update(['statut' => Candidature::STATUT_VUE]));

        return view('employeur_candidats', compact('offre', 'candidatures'));
    }

    /**
     * Programme un entretien avec un candidat.
     */
    public function programmerEntretien(Request $request, Candidature $candidature): RedirectResponse
    {
        $this->verifierEmployeur();
        $this->verifierProprieteCandidat($candidature);

        $request->validate([
            'entretien_date'  => 'required|date|after_or_equal:today',
            'entretien_heure' => 'required|date_format:H:i',
            'note_employeur'  => 'nullable|string|max:500',
        ], [
            'entretien_date.after_or_equal' => 'La date doit être aujourd\'hui ou dans le futur.',
            'entretien_heure.date_format'   => 'Format d\'heure invalide (HH:MM).',
        ]);

        $candidature->update([
            'statut'          => Candidature::STATUT_ENTRETIEN_PROGRAMME,
            'entretien_date'  => $request->entretien_date,
            'entretien_heure' => $request->entretien_heure . ':00',
            'note_employeur'  => $request->note_employeur,
        ]);

        // Notifier le candidat
        $candidature->load(['user', 'offre.entreprise']);
        $candidature->user->notify(new EntretienProgrammeNotification($candidature));

        return redirect()->back()->with('succes', 'Entretien programmé ! Le candidat a été notifié par email.');
    }

    /**
     * Rejette le dossier d'un candidat.
     */
    public function rejeterDossier(Candidature $candidature): RedirectResponse
    {
        $this->verifierEmployeur();
        $this->verifierProprieteCandidat($candidature);

        $candidature->update(['statut' => Candidature::STATUT_REFUSEE]);

        $candidature->load(['user', 'offre.entreprise']);
        $candidature->user->notify(new DossierRejeteNotification($candidature));

        return redirect()->back()->with('succes', 'Dossier refusé. Le candidat a été notifié par email.');
    }

    private function verifierEmployeur(): void
    {
        if (!Auth::check() || !Auth::user()->isEmployeur()) {
            abort(403, 'Accès réservé aux employeurs.');
        }
    }

    private function verifierPropriete(Offre $offre): void
    {
        if ($offre->posted_by_user_id !== Auth::id()) {
            abort(403);
        }
    }

    private function verifierProprieteCandidat(Candidature $candidature): void
    {
        $candidature->load('offre');
        if ($candidature->offre->posted_by_user_id !== Auth::id()) {
            abort(403);
        }
    }
}

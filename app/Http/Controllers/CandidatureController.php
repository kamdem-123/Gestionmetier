<?php

namespace App\Http\Controllers;

use App\Jobs\AnalyserMatchingJob;
use App\Models\Candidature;
use App\Models\Offre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidatureController extends Controller
{
    /**
     * Affiche le formulaire de candidature pour une offre.
     */
    public function show(Request $request)
    {
        $offreId = $request->query('id');

        if (!$offreId) {
            return redirect('/')->with('erreur', 'Offre introuvable.');
        }

        $offre = Offre::with('entreprise')->findOrFail($offreId);

        // Vérifier si le candidat a déjà postulé
        $dejaPostule = false;
        if (Auth::check()) {
            $dejaPostule = Candidature::where('user_id', Auth::id())
                ->where('offre_id', $offre->id)
                ->exists();
        }

        return view('postuler', compact('offre', 'dejaPostule'));
    }

    /**
     * Enregistre la candidature et déclenche le matching AI.
     */
    public function postuler(Request $request)
    {
        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect('/connexion')->with('info', 'Connectez-vous pour postuler.');
        }

        $request->validate([
            'offre_id'    => 'required|exists:offres,id',
            'titre_poste' => 'nullable|string|max:255',
            'competences' => 'nullable|string|max:2000',
            'cv_texte'    => 'nullable|string|max:5000',
        ]);

        $user    = Auth::user();
        $offreId = $request->input('offre_id');

        // Mettre à jour le profil de l'utilisateur avec les informations saisies
        $user->update([
            'titre_poste' => $request->input('titre_poste'),
            'competences' => $request->input('competences'),
            'cv_texte'    => $request->input('cv_texte'),
        ]);

        // Vérifier doublon
        $existe = Candidature::where('user_id', $user->id)
            ->where('offre_id', $offreId)
            ->exists();

        if ($existe) {
            return redirect()->back()->with('erreur', 'Vous avez déjà postulé à cette offre.');
        }

        // Créer la candidature
        $candidature = Candidature::create([
            'user_id'  => $user->id,
            'offre_id' => $offreId,
            'statut'   => 'en_attente',
        ]);

        // Déclencher le matching AI en arrière-plan (non bloquant)
        AnalyserMatchingJob::dispatch($candidature);

        return redirect('/dashboard')->with('succes', 'Candidature envoyée ! Notre IA analyse votre profil.');
    }

    /**
     * Met à jour le profil candidat (compétences, titre, cv_texte).
     */
    public function mettreAJourProfil(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/connexion');
        }

        $request->validate([
            'titre_poste'  => 'nullable|string|max:255',
            'competences'  => 'nullable|string|max:2000',
            'cv_texte'     => 'nullable|string|max:5000',
        ]);

        Auth::user()->update([
            'titre_poste' => $request->input('titre_poste'),
            'competences' => $request->input('competences'),
            'cv_texte'    => $request->input('cv_texte'),
        ]);

        return redirect('/dashboard')->with('succes', 'Profil mis à jour ! Le matching sera recalculé automatiquement.');
    }
}

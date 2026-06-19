<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class OffresController extends Controller
{
    public function index(Request $request)
    {
        $query = Offre::with('entreprise')
            ->where('status', 'active');

        // Filtres manuels
        if ($kw = $request->input('q')) {
            $query->where(function ($q) use ($kw) {
                $q->where('titre', 'like', "%{$kw}%")
                  ->orWhere('competences', 'like', "%{$kw}%")
                  ->orWhere('description', 'like', "%{$kw}%")
                  ->orWhereHas('entreprise', fn($e) => $e->where('nom', 'like', "%{$kw}%"));
            });
        }
        if ($type = $request->input('type_contrat')) {
            $query->where('type_contrat', $type);
        }
        if ($lieu = $request->input('lieu')) {
            $query->where(function ($q) use ($lieu) {
                $q->where('ville', 'like', "%{$lieu}%")
                  ->orWhere('pays', 'like', "%{$lieu}%");
            });
        }

        $user           = auth()->user();
        $candidatConnecte = $user && $user->isCandidat() && !empty($user->competences);
        $totalActif     = Offre::where('status', 'active')->count();

        if ($candidatConnecte && !$request->hasAny(['q', 'type_contrat', 'lieu'])) {
            // Tri automatique par score de correspondance
            $offresAll = $query->get();
            $offresAll = $this->scorerEtTrier($offresAll, $user);
            $offres    = $this->paginer($offresAll, 12, $request);
        } else {
            // Ordre chronologique par défaut (ou si recherche manuelle)
            $offres = $query->orderByDesc('date_publication')->paginate(12)->withQueryString();
        }

        return view('offres_liste', compact('offres', 'totalActif', 'candidatConnecte'));
    }

    // ─── Calcul de score Jaccard local (rapide, sans API) ────────────
    private function scorerEtTrier(Collection $offres, $user): Collection
    {
        $motsCandidat = $this->extraireMots(
            ($user->competences ?? '') . ' ' . ($user->titre_poste ?? '')
        );

        return $offres->map(function ($offre) use ($motsCandidat) {
            $motsOffre = $this->extraireMots(
                ($offre->competences ?? '') . ' ' . ($offre->titre ?? '')
            );
            $offre->match_score = $this->jaccard($motsCandidat, $motsOffre);
            return $offre;
        })->sortByDesc('match_score')->values();
    }

    private function extraireMots(string $texte): array
    {
        $texte = mb_strtolower($texte, 'UTF-8');
        $texte = preg_replace('/[^\w\s\p{L}]/u', ' ', $texte);
        $mots  = preg_split('/\s+/', $texte, -1, PREG_SPLIT_NO_EMPTY);
        return array_unique(array_filter($mots, fn($m) => mb_strlen($m, 'UTF-8') > 2));
    }

    private function jaccard(array $a, array $b): float
    {
        if (empty($a) || empty($b)) return 0.0;
        $communs = array_intersect($a, $b);
        return round(count($communs) / max(count($a), count($b)) * 100, 1);
    }

    private function paginer(Collection $items, int $perPage, Request $request): LengthAwarePaginator
    {
        $page    = $request->input('page', 1);
        $slice   = $items->slice(($page - 1) * $perPage, $perPage)->values();
        return new LengthAwarePaginator(
            $slice, $items->count(), $perPage, $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    }
}

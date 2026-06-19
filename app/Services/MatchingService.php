<?php

namespace App\Services;

use App\Models\Offre;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MatchingService
{
    private string $apiKey;
    private string $apiUrl = 'https://router.huggingface.co/hf-inference/models/sentence-transformers/all-MiniLM-L6-v2/pipeline/feature-extraction';
    private float $seuilScore;

    public function __construct()
    {
        $this->apiKey = config('services.huggingface.api_key');
        $this->seuilScore = (float) config('services.huggingface.seuil_score', 70);
    }

    /**
     * Appelle l'API Hugging Face et retourne le vecteur embedding du texte.
     * En cas d'erreur API, retourne un tableau vide et log l'erreur.
     */
    public function getEmbedding(string $texte): array
    {
        try {
            $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json',
            ])->timeout(30)->post($this->apiUrl, [
                'inputs' => $texte,
            ]);

            if ($response->failed()) {
                Log::error('MatchingService: erreur API HuggingFace', [
                    'status'  => $response->status(),
                    'body'    => $response->body(),
                ]);
                return [];
            }

            $data = $response->json();

            // L'API retourne soit [[...vecteur...]] soit [...vecteur...]
            // On normalise pour toujours retourner un tableau 1D de floats
            if (isset($data[0]) && is_array($data[0])) {
                return $data[0];
            }

            return $data;

        } catch (\Exception $e) {
            Log::error('MatchingService: exception HTTP', ['message' => $e->getMessage()]);
            return [];
        }
    }

    /**
     * Calcule la similarité cosinus entre deux vecteurs.
     * Retourne un float entre 0 et 100 (pourcentage).
     * Retourne 0 si l'un des vecteurs est vide.
     */
    public function similariteCosinus(array $vecA, array $vecB): float
    {
        if (empty($vecA) || empty($vecB)) {
            return 0.0;
        }

        $dotProduct  = 0.0;
        $normA       = 0.0;
        $normB       = 0.0;
        $longueur    = min(count($vecA), count($vecB));

        for ($i = 0; $i < $longueur; $i++) {
            $dotProduct += $vecA[$i] * $vecB[$i];
            $normA      += $vecA[$i] ** 2;
            $normB      += $vecB[$i] ** 2;
        }

        $denominateur = sqrt($normA) * sqrt($normB);

        if ($denominateur == 0) {
            return 0.0;
        }

        $similarite = $dotProduct / $denominateur;

        // Convertir en pourcentage (la similarité cosinus est entre -1 et 1)
        return round(max(0, $similarite) * 100, 2);
    }

    /**
     * Calcule le score de matching entre une offre et un candidat.
     * Retourne un float entre 0 et 100.
     */
    public function calculerScore(Offre $offre, User $candidat): float
    {
        $texteOffre    = $this->construireTexteOffre($offre);
        $texteCandidat = $this->construireTexteCandidat($candidat);

        if (empty($texteOffre) || empty($texteCandidat)) {
            return 0.0;
        }

        $vecOffre    = $this->getEmbedding($texteOffre);
        $vecCandidat = $this->getEmbedding($texteCandidat);

        $score = $this->similariteCosinus($vecOffre, $vecCandidat);

        // Fallback si l'API Hugging Face a échoué (vecteurs vides)
        if ($score == 0.0 && (empty($vecOffre) || empty($vecCandidat))) {
            return $this->calculerScoreFallback($texteOffre, $texteCandidat);
        }

        return $score;
    }

    /**
     * Algorithme de secours (fallback) basé sur l'intersection de mots-clés.
     * Utile si l'API HuggingFace ou la connexion réseau échoue.
     */
    private function calculerScoreFallback(string $texteOffre, string $texteCandidat): float
    {
        $clean = function($text) {
            $text = mb_strtolower($text, 'UTF-8');
            $text = preg_replace('/[^\w\s\p{L}]/u', ' ', $text);
            $mots = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
            return array_filter($mots, function($mot) {
                return mb_strlen($mot, 'UTF-8') > 2;
            });
        };

        $motsOffre = array_unique($clean($texteOffre));
        $motsCandidat = array_unique($clean($texteCandidat));

        if (empty($motsOffre) || empty($motsCandidat)) {
            return 0.0;
        }

        $communs = array_intersect($motsOffre, $motsCandidat);
        
        // Jaccard similarity index
        $score = (count($communs) / max(count($motsOffre), count($motsCandidat))) * 100;

        return round(min(100, max(0, $score)), 2);
    }

    /**
     * Construit le texte représentatif d'une offre pour l'embedding.
     */
    public function construireTexteOffre(Offre $offre): string
    {
        $parties = array_filter([
            $offre->titre,
            $offre->competences,
            $offre->categorie,
            mb_substr($offre->description ?? '', 0, 500),
        ]);

        return implode('. ', $parties);
    }

    /**
     * Construit le texte représentatif d'un candidat pour l'embedding.
     */
    public function construireTexteCandidat(User $candidat): string
    {
        $parties = array_filter([
            $candidat->titre_poste,
            $candidat->competences,
            $candidat->cv_texte,
        ]);

        return implode('. ', $parties);
    }

    /**
     * Vérifie si un score dépasse le seuil configuré.
     */
    public function estBonMatch(float $score): bool
    {
        return $score >= $this->seuilScore;
    }

}

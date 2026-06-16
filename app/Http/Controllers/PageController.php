<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function welcome(Request $request): View
    {
        $search_keyword = $request->query('keyword', '');
        $search_location = $request->query('location', '');

        $latest_jobs = [];

        try {
            $latest_jobs = DB::table('offres as o')
                ->leftJoin('entreprises as e', 'o.entreprise_id', 'e.id')
                ->select('o.*', 'e.nom as entreprise_nom')
                ->orderByDesc('o.date_publication')
                ->limit(8)
                ->get()
                ->map(function ($item) {
                    $job = (array) $item;
                    $job['tags'] = $job['tags'] ?? '';
                    $job['flag'] = $job['flag'] ?? '';
                    $job['salary_eur'] = $job['salary_eur'] ?? 0;
                    $job['salary_type'] = $job['salary_type'] ?? 'year';

                    return $job;
                })
                ->toArray();
        } catch (\Exception $e) {
            $latest_jobs = [];
        }

        if (empty($latest_jobs)) {
            $latest_jobs = $this->demoJobs();
        }

        return view('welcomP', compact('search_keyword', 'search_location', 'latest_jobs'));
    }

    public function signUp(): View
    {
        return view('inscrit');
    }

    public function login(): View
    {
        return view('connexion');
    }

    public function cvGallery(): View
    {
        return view('cv_gallery');
    }

    public function test(): View
    {
        return view('test');
    }

    protected function demoJobs(): array
    {
        return [
            [
                'titre' => 'Développeur Full Stack',
                'entreprise_nom' => 'TechCorp Solutions',
                'type_contrat' => 'CDI',
                'tags' => 'React,Laravel,MySQL',
                'salaire' => '45 000',
                'devise' => '€',
                'periode' => '/an',
                'ville' => 'Paris',
                'pays' => 'France',
                'flag' => '🇫🇷',
                'date_publication' => '2026-06-10',
                'salary_eur' => 45000,
                'salary_type' => 'year',
            ],
            [
                'titre' => 'Chef de Projet Marketing',
                'entreprise_nom' => 'Digital Agency',
                'type_contrat' => 'CDD',
                'tags' => 'SEO,Google Ads,Analytics',
                'salaire' => '38 000',
                'devise' => '€',
                'periode' => '/an',
                'ville' => 'Lyon',
                'pays' => 'France',
                'flag' => '🇫🇷',
                'date_publication' => '2026-06-11',
                'salary_eur' => 38000,
                'salary_type' => 'year',
            ],
            [
                'titre' => 'Data Scientist',
                'entreprise_nom' => 'AI Innovations',
                'type_contrat' => 'Freelance',
                'tags' => 'Python,Machine Learning,TensorFlow',
                'salaire' => '500',
                'devise' => '€',
                'periode' => '/jour',
                'ville' => 'Montréal',
                'pays' => 'Canada',
                'flag' => '🇨🇦',
                'date_publication' => '2026-06-14',
                'salary_eur' => 500,
                'salary_type' => 'day',
            ],
            [
                'titre' => 'UX/UI Designer',
                'entreprise_nom' => 'Creative Studio',
                'type_contrat' => 'Stage',
                'tags' => 'Figma,Adobe XD,Prototypage',
                'salaire' => '150 000',
                'devise' => 'FCFA',
                'periode' => '/mois',
                'ville' => 'Douala',
                'pays' => 'Cameroun',
                'flag' => '🇨🇲',
                'date_publication' => '2026-06-13',
                'salary_eur' => 229,
                'salary_type' => 'month',
            ],
            [
                'titre' => 'Ingénieur DevOps',
                'entreprise_nom' => 'Cloud Systems',
                'type_contrat' => 'CDI',
                'tags' => 'Docker,Kubernetes,AWS',
                'salaire' => '55 000',
                'devise' => '€',
                'periode' => '/an',
                'ville' => 'Bruxelles',
                'pays' => 'Belgique',
                'flag' => '🇧🇪',
                'date_publication' => '2026-06-09',
                'salary_eur' => 55000,
                'salary_type' => 'year',
            ],
            [
                'titre' => 'Consultant SAP',
                'entreprise_nom' => 'ERP Consulting',
                'type_contrat' => 'CDI',
                'tags' => 'SAP,ABAP,FI/CO',
                'salaire' => '120 000',
                'devise' => 'CHF',
                'periode' => '/an',
                'ville' => 'Genève',
                'pays' => 'Suisse',
                'flag' => '🇨🇭',
                'date_publication' => '2026-06-08',
                'salary_eur' => 112800,
                'salary_type' => 'year',
            ],
            [
                'titre' => 'Développeur Mobile Flutter',
                'entreprise_nom' => 'Savtontine Tech',
                'type_contrat' => 'CDI',
                'tags' => 'Flutter,Dart,Firebase',
                'salaire' => '2 500',
                'devise' => '€',
                'periode' => '/mois',
                'ville' => 'Dakar',
                'pays' => 'Sénégal',
                'flag' => '🇸🇳',
                'date_publication' => '2026-06-12',
                'salary_eur' => 2500,
                'salary_type' => 'month',
            ],
            [
                'titre' => 'Comptable Senior',
                'entreprise_nom' => 'Finances & Co',
                'type_contrat' => 'CDI',
                'tags' => 'Comptabilité,SAP,Audit',
                'salaire' => '1 200 000',
                'devise' => 'FCFA',
                'periode' => '/mois',
                'ville' => 'Abidjan',
                'pays' => "Côte d'Ivoire",
                'flag' => '🇨🇮',
                'date_publication' => '2026-06-07',
                'salary_eur' => 1830,
                'salary_type' => 'month',
            ],
        ];
    }
}

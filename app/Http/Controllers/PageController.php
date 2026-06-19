<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function welcome(Request $request): View
    {
        $latest_jobs = [];

        try {
            $latest_jobs = DB::table('offres as o')
                ->leftJoin('entreprises as e', 'o.entreprise_id', 'e.id')
                ->select('o.*', 'e.nom as entreprise_nom')
                ->where('o.status', 'active')
                ->orderByDesc('o.date_publication')
                ->limit(6)
                ->get()
                ->map(function ($item) {
                    $job = (array) $item;
                    $job['tags']        = $job['competences'] ?? $job['tags'] ?? '';
                    $job['flag']        = $job['flag'] ?? '';
                    $job['salary_eur']  = $job['salary_eur'] ?? 0;
                    $job['salary_type'] = $job['salary_type'] ?? 'month';
                    return $job;
                })
                ->toArray();
        } catch (\Exception $e) {
            $latest_jobs = [];
        }

        return view('welcomP', compact('latest_jobs'));
    }

    public function signUp(): View
    {
        return view('inscrit');
    }
}

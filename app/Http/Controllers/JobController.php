<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class JobController extends Controller
{
    public function publish(): View
    {
        return view('publier_offre');
    }

    public function searchByKeyword(): View
    {
        return view('recherche-metier');
    }

    public function searchByLocation(): View
    {
        return view('recherche-localisation');
    }
}

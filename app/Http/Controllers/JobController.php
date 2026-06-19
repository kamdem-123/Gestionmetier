<?php

namespace App\Http\Controllers;

use App\Models\DemandeEmployeur;
use App\Models\Entreprise;
use App\Models\Offre;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'titre'        => 'required|string|max:255',
            'type_contrat' => 'required|string|max:100',
            'ville'        => 'required|string|max:150',
            'pays'         => 'required|string|max:100',
            'description'  => 'required|string|min:50',
            'competences'  => 'required|string|max:1000',
        ], [
            'description.min' => 'La description doit contenir au moins 50 caractères.',
        ]);

        $user   = Auth::user();
        $demande = DemandeEmployeur::where('email', $user->email)->first();

        $nomEntreprise     = $demande?->entreprise ?? $user->name;
        $secteurEntreprise = $demande?->secteur ?? '';

        $entreprise = Entreprise::firstOrCreate(
            ['nom' => $nomEntreprise],
            ['secteur' => $secteurEntreprise, 'email_contact' => $user->email]
        );

        Offre::create([
            'titre'             => $request->titre,
            'entreprise_id'     => $entreprise->id,
            'type_contrat'      => $request->type_contrat,
            'mode_travail'      => $request->mode_travail ?? '',
            'localisation'      => $request->ville . ', ' . $request->pays,
            'ville'             => $request->ville,
            'pays'              => $request->pays,
            'categorie'         => $request->categorie ?? $secteurEntreprise,
            'description'       => $request->description,
            'competences'       => $request->competences,
            'salaire_min'       => $request->salaire_min ?: null,
            'salaire_max'       => $request->salaire_max ?: null,
            'devise'            => $request->devise ?? 'XAF',
            'salary_type'       => $request->salary_type ?? 'month',
            'date_publication'  => now()->toDateString(),
            'status'            => Offre::STATUS_PENDING,
            'posted_by_user_id' => $user->id,
        ]);

        return redirect()->route('employeur.dashboard')
            ->with('succes', "Offre soumise ! Elle sera publiée après validation par l'administrateur.");
    }

    public function approuver(Offre $offre): RedirectResponse
    {
        if (!Auth::user()->isAdmin()) abort(403);
        $offre->update(['status' => Offre::STATUS_ACTIVE]);
        return redirect('/admin')->with('succes', "L'offre \"{$offre->titre}\" est maintenant publiée.");
    }

    public function rejeter(Offre $offre): RedirectResponse
    {
        if (!Auth::user()->isAdmin()) abort(403);
        $offre->update(['status' => Offre::STATUS_INACTIVE]);
        return redirect('/admin')->with('info', "L'offre \"{$offre->titre}\" a été rejetée.");
    }
}

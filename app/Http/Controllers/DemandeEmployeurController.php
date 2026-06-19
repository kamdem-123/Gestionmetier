<?php

namespace App\Http\Controllers;

use App\Models\DemandeEmployeur;
use App\Models\User;
use App\Notifications\CompteEmployeurApprouveNotification;
use App\Notifications\CompteEmployeurRefuseNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class DemandeEmployeurController extends Controller
{
    public function showForm()
    {
        return view('demande_employeur');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nom'        => 'required|string|max:100',
            'prenom'     => 'nullable|string|max:100',
            'email'      => 'required|email|unique:demandes_employeur,email|unique:users,email',
            'telephone'  => 'nullable|string|max:20',
            'entreprise' => 'required|string|max:255',
            'secteur'    => 'nullable|string|max:100',
            'message'    => 'nullable|string|max:1000',
            'password'   => 'required|string|min:8|confirmed',
        ], [
            'email.unique' => 'Un compte ou une demande existe déjà avec cet email.',
        ]);

        DemandeEmployeur::create([
            'nom'        => $request->nom,
            'prenom'     => $request->prenom,
            'email'      => $request->email,
            'telephone'  => $request->telephone,
            'entreprise' => $request->entreprise,
            'secteur'    => $request->secteur,
            'message'    => $request->message,
            'password'   => Hash::make($request->password),
            'statut'     => DemandeEmployeur::STATUT_PENDING,
        ]);

        return redirect('/connexion')->with('succes', 'Votre demande a été envoyée. Vous recevrez un email dès validation par notre équipe.');
    }

    /**
     * L'admin approuve la demande → crée le compte employeur.
     */
    public function approuver(DemandeEmployeur $demande): RedirectResponse
    {
        $this->verifierAdmin();

        if ($demande->statut !== DemandeEmployeur::STATUT_PENDING) {
            return redirect('/admin')->with('info', 'Cette demande a déjà été traitée.');
        }

        // Générer un mot de passe lisible à envoyer par email
        $motDePasse = Str::random(10);

        // Créer le compte utilisateur (le cast 'hashed' du modèle hash automatiquement)
        User::create([
            'name'              => trim($demande->prenom . ' ' . $demande->nom),
            'email'             => $demande->email,
            'password'          => $motDePasse,
            'role'              => User::ROLE_EMPLOYEUR,
            'is_admin'          => false,
            'email_verified_at' => now(),
        ]);

        // Marquer la demande comme approuvée
        $demande->update(['statut' => DemandeEmployeur::STATUT_APPROVED]);

        // Envoyer email d'approbation (non bloquant si le mail échoue)
        $emailEnvoye = true;
        try {
            Notification::route('mail', $demande->email)
                ->notify(new CompteEmployeurApprouveNotification(
                    $demande->entreprise,
                    $demande->email,
                    $motDePasse,
                ));
        } catch (\Exception $e) {
            $emailEnvoye = false;
            \Illuminate\Support\Facades\Log::error('Email approbation employeur échoué', ['error' => $e->getMessage()]);
        }

        $msg = "Compte employeur créé pour {$demande->email}.";
        $msg .= $emailEnvoye ? ' Un email de confirmation a été envoyé.' : " (Email non envoyé — mot de passe temporaire : {$motDePasse})";

        return redirect('/admin')->with('succes', $msg);
    }

    /**
     * L'admin rejette la demande.
     */
    public function rejeter(DemandeEmployeur $demande): RedirectResponse
    {
        $this->verifierAdmin();

        if ($demande->statut !== DemandeEmployeur::STATUT_PENDING) {
            return redirect('/admin')->with('info', 'Cette demande a déjà été traitée.');
        }

        $demande->update(['statut' => DemandeEmployeur::STATUT_REJECTED]);

        try {
            Notification::route('mail', $demande->email)
                ->notify(new CompteEmployeurRefuseNotification($demande->entreprise));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Email refus employeur échoué', ['error' => $e->getMessage()]);
        }

        return redirect('/admin')->with('info', "Demande de {$demande->email} refusée.");
    }

    private function verifierAdmin(): void
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403);
        }
    }
}

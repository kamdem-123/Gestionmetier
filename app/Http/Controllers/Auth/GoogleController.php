<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;

class GoogleController extends Controller
{
    /**
     * Redirection vers Google
     */
    public function redirect(): SymfonyRedirectResponse
    {
        $driver = Socialite::driver('google');
        
        // Force la configuration manuellement
        $driver->redirectUrl('http://localhost:8000/auth/google/callback');
        
        return $driver->redirect();
    }

    /**
     * Callback après connexion Google
     */
    public function callback(): RedirectResponse
    {
        try {
            $driver = Socialite::driver('google');
            $driver->redirectUrl('http://localhost:8000/auth/google/callback');
            
            $googleUser = $driver->user();

            // Chercher ou créer l'utilisateur
            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => Hash::make(uniqid()),
                ]
            );

            Auth::login($user);
             return redirect()->route('dashboard');

        } catch (\Exception $e) {
            return redirect('/dashboard')->with('error', 'Erreur Google : ' . $e->getMessage());
        }
    }
}
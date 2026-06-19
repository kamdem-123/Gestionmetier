<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Redirection si mauvais rôle
        if ($user->isAdmin())     return redirect('/admin');
        if ($user->isEmployeur()) return redirect('/employeur');

        // Notifications non lues
        $notifications = $user->unreadNotifications()->latest()->take(10)->get();
        $totalNonLues  = $user->unreadNotifications()->count();

        // Toutes les candidatures du candidat avec statut enrichi
        $candidatures = $user->candidatures()
            ->with(['offre.entreprise'])
            ->orderByDesc('created_at')
            ->get();

        // Stats
        $totalPostules         = $candidatures->count();
        $entretiensProgammes   = $candidatures->where('statut', 'entretien_programme')->count();
        $refusees              = $candidatures->where('statut', 'refusee')->count();
        $enCours               = $candidatures->whereIn('statut', ['en_attente', 'vue'])->count();

        return view('dashboard', compact(
            'user', 'notifications', 'totalNonLues', 'candidatures',
            'totalPostules', 'entretiensProgammes', 'refusees', 'enCours'
        ));
    }

    public function liveNotifications()
    {
        $user  = Auth::user();
        $notifs = $user->unreadNotifications()->latest()->take(10)->get()
            ->map(fn($n) => [
                'id'        => $n->id,
                'type'      => $n->data['type']      ?? '',
                'message'   => $n->data['message']   ?? '',
                'offre'     => $n->data['offre_titre'] ?? '',
                'date'      => $n->entretien_date     ?? ($n->data['entretien_date'] ?? ''),
                'heure'     => $n->entretien_heure    ?? ($n->data['entretien_heure'] ?? ''),
                'ago'       => $n->created_at->diffForHumans(),
                'read'      => false,
            ]);

        return response()->json([
            'total'   => $user->unreadNotifications()->count(),
            'notifs'  => $notifs,
        ]);
    }

    public function marquerLu(Request $request)
    {
        $notifId = $request->input('notification_id');

        if ($notifId) {
            Auth::user()->notifications()->where('id', $notifId)->update(['read_at' => now()]);
        } else {
            Auth::user()->unreadNotifications->markAsRead();
        }

        return response()->json(['success' => true]);
    }
}

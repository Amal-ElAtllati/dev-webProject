<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = auth()->user();

        $roleMessages = [
            'admin' => 'Bienvenue, administrateur! Vous êtes connecté avec succès.',
            'responsable' => 'Bienvenue, responsable technique! Vous êtes connecté avec succès.',
            'user' => 'Bienvenue! Vous êtes connecté avec succès.'
        ];

        $message = $roleMessages[$user->role] ?? 'Vous êtes connecté avec succès.';

        if ($user->role === 'admin') {
           return redirect('/admin/dashboard')->with('success', $message);
        } elseif ($user->role === 'responsable') {
           return redirect('/responsable/dashboard')->with('success', $message);
        }

        return redirect('/user/dashboard')->with('success', $message);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Vous êtes déconnecté avec succès. À bientôt!');
    }
}

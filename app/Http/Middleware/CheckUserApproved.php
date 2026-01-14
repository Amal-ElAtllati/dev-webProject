<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserApproved
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Si status = pending
            if ($user->status === 'pending') {
                Auth::logout();
                return redirect('/')
                    ->with('warning', '⏳ Votre compte est en attente d\'approbation. Vous recevrez un email une fois approuvé.');
            }
            
            // Si status = rejected
            if ($user->status === 'rejected') {
                Auth::logout();
                return redirect('/')
                    ->with('error', '❌ Votre demande d\'inscription a été refusée.');
            }
        }
        
        return $next($request);
    }
}
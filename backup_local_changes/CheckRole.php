<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();
        
        if (!$user) {
            abort(403, "Accès interdit");
        }

        // Check if user has any of the required roles
        $userRoles = $user->roles->pluck('name')->toArray();
        $hasRole = false;
        
        foreach ($roles as $role) {
            if (in_array($role, $userRoles)) {
                $hasRole = true;
                break;
            }
        }

        if (!$hasRole) {
            abort(403, "Accès interdit");
        }

        return $next($request);
    }
}

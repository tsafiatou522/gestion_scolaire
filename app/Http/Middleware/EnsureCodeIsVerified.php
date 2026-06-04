<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureCodeIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Vérifier si l'utilisateur est enseignant et n'a pas validé son code
        if ($user && $user->role === 'enseignant' && $user->verification_code !== null) {
            return redirect()->route('verification.code')
                             ->with('error', 'Veuillez entrer votre code de vérification.');
        }

        return $next($request);
    }
}

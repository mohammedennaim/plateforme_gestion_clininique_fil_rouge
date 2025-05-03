<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        $user = Auth::user();

        if (!$user->isActive()) {
            return redirect()->route('home')->with('error', 'Votre compte n\'est pas actif. Veuillez contacter l\'administrateur.');
        }

        if ($user->isPending()) {
            return redirect()->route('home')->with('warning', 'Votre compte est en attente d\'approbation.');
        }

        foreach ($roles as $role) {
            if ($user->role === $role) {
                
        dd("ggg");
                return $next($request);
            }
        }

        return redirect()->route('home')->with('error', 'Accès refusé. Vous n\'avez pas les permissions nécessaires pour accéder à cette page.');
    }
} 
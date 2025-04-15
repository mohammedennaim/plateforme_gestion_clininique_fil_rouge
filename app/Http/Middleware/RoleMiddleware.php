<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role  Le rôle requis pour accéder à cette route
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        $user = Auth::user();

        // Vérifier si l'utilisateur a le rôle requis
        if ($user->role !== $role) {
            return redirect()->route('home')->with('error', 'Vous n\'avez pas les permissions nécessaires pour accéder à cette page.');
        }

        // Vérifier si le compte de l'utilisateur est actif
        if (!$user->isActive()) {
            return redirect()->route('home')->with('error', 'Votre compte n\'est pas actif. Veuillez contacter l\'administrateur.');
        }

        return $next($request);
    }
}
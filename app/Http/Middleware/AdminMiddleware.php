<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        $user = Auth::user();

        // Vérification améliorée : on utilise la méthode isAdmin() et on vérifie si le compte est actif
        if (!$user->isAdmin()) {
            return redirect()->route('home')->with('error', 'Accès réservé aux administrateurs.');
        }

        // Vérification que le compte est actif
        if (!$user->isActive()) {
            return redirect()->route('home')->with('error', 'Votre compte administrateur n\'est pas actif. Veuillez contacter le support.');
        }

        return $next($request);
    }
}

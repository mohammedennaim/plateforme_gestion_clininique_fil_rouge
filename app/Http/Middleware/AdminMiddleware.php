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

        if (!$user->isAdmin()) {
            return redirect()->route('home')->with('error', 'Accès réservé aux administrateurs.');
        }

        if (!$user->isActive()) {
            return redirect()->route('home')->with('error', 'Votre compte n\'est pas actif. Veuillez contacter l\'administrateur principal.');
        }

        return $next($request);
    }
}

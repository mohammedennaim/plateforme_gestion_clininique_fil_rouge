<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DoctorMiddleware
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

        if (!$user->isDoctor()) {
            return redirect()->route('home')->with('error', 'Accès réservé aux médecins.');
        }

        if (!$user->isActive()) {
            return redirect()->route('home')->with('error', 'Votre compte n\'est pas actif. Veuillez contacter l\'administrateur.');
        }

        if ($user->isPending()) {
            return redirect()->route('doctor.pending')->with('warning', 'Votre compte est en attente d\'approbation.');
        }

        return $next($request);
    }
}

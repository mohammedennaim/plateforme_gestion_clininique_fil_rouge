<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $permission  La permission requise pour accéder à cette route
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        $user = Auth::user();

        // Pour cet exemple, nous utilisons une approche simplifiée où les permissions sont basées sur le rôle
        // Dans une implémentation plus complète, vous pourriez avoir une table séparée pour les permissions
        
        // Permissions par défaut pour chaque rôle
        $permissions = [
            'admin' => ['manage_doctors', 'manage_patients', 'manage_appointments', 'view_statistics', 'manage_settings'],
            'doctor' => ['view_patients', 'manage_own_appointments', 'view_medical_records'],
            'patient' => ['book_appointments', 'view_own_appointments', 'view_own_medical_records']
        ];

        // Vérifier si l'utilisateur a la permission requise
        if (!isset($permissions[$user->role]) || !in_array($permission, $permissions[$user->role])) {
            return redirect()->route('home')->with('error', 'Vous n\'avez pas les permissions nécessaires pour accéder à cette page.');
        }

        return $next($request);
    }
}
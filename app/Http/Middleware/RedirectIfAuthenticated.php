<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                
                // Cas spécial pour les médecins en attente
                if ($user->isDoctor() && $user->isPending()) {
                    return redirect()->route('doctor.pending');
                }
                
                // Pour les autres cas, utiliser la méthode getHomeRoute
                return redirect(RouteServiceProvider::getHomeRoute($user->role));
            }
        }

        return $next($request);
    }
}

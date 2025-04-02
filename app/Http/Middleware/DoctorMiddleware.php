<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\Console\Migrations\RollbackCommand;
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
        if ($request->user() && $request->user()->role === 'doctor') {
            return $next($request);
        }
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        }
        if (Auth::user()->role !== 'doctor') {
            return redirect('home')->with('error', 'Only doctors can access this area.');
        }
        if (Auth::user()->role === 'doctor' && Auth::user()->status === 'pending') {
            return redirect()->route('doctor.pending')->with('warning', 'Your account is pending approval.');
        }
        return redirect('/login')->withErrors(['access' => 'You do not have access to this page.']);
    }
}

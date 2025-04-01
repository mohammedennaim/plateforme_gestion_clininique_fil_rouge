<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\AuthRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authRepository;
    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function authenticate(Request $request)
    {
        $user = $this->authRepository->login($request->all());
        if ($user) {
            Auth::login($user);
            $request->session()->regenerate();

            if ($user->role === 'doctor') {
                return redirect('/doctor/dashboard');
            } elseif ($user->role === 'patient') {
                return redirect('/home');
            }else {
                return redirect('/admin/dashboard')->withErrors(['login' => 'Invalid credentials.']);
            }
        } else {
            return redirect()->back()->withErrors(['login' => 'Invalid credentials.']);
        }
    }

    public function store(Request $request)
    {
        $user = $this->authRepository->register($request->all());

        if ($user->role === 'doctor' && $user->status === 'active') {
            return redirect()->route('auth.doctor-pending');
        } else {
            return redirect()->route('login');
        }
    }

    public function logout(Request $request)
    {
        $user = $this->authRepository->logout();
        if ($user) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/auth/login')->with('success', 'Logout successful.');
        }
        return redirect()->back()->withErrors(['logout' => 'Logout failed.']);
    }

    public function doctorPending()
    {
        return view('auth.doctor-pending');
    }
}
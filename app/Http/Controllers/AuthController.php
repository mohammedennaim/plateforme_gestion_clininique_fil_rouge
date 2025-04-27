<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\AuthRepository;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    protected $authRepository;
    
    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
        $this->middleware('guest')->only([
            'login', 'register', 'authenticate', 'store', 
            'showForgotPasswordForm', 'sendResetLinkEmail',
            'showResetPasswordForm', 'resetPassword'
        ]);
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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = $this->authRepository->login($request->all());
        
        if ($user) {
            Auth::login($user);
            $request->session()->regenerate();

            if ($user->isDoctor() && $user->isPending()) {
                return redirect()->route('doctor.pending')
                    ->with('warning', 'Votre compte est en attente de validation par un administrateur.');
            }
            
            return redirect(RouteServiceProvider::getHomeRoute($user->role))
            ->with('success', 'Connexion réussie. Bienvenue !');
        } else {
           
            return redirect()->route('login')
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Ces identifiants ne correspondent pas à nos enregistrements.']);
        }
    
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:patient,doctor',
        ]);

        $user = $this->authRepository->register($request->all());

        if ($user) {
            if ($user->isDoctor()) {
                return redirect()->route('doctor.pending')
                    ->with('info', 'Votre compte a été créé mais il doit être validé par un administrateur avant que vous puissiez vous connecter.');
            }
            
            Auth::login($user);
            return redirect(RouteServiceProvider::getHomeRoute($user->role))
            ->with('success', 'Votre compte a été créé avec succès.');
        }
    
        return redirect()->back()
            ->withInput()
            ->withErrors(['error' => 'Une erreur est survenue lors de la création de votre compte. Veuillez réessayer.']);
    }

    public function showForgotPasswordForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPasswordForm(Request $request, $token)
    {
        return view('auth.passwords.reset', ['token' => $token, 'email' => $request->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }

}
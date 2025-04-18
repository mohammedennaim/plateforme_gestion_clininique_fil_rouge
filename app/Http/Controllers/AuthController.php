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
        // Appliquer le middleware guest uniquement aux méthodes qui doivent être accessibles aux utilisateurs non connectés
        $this->middleware('guest')->only([
            'login', 'register', 'authenticate', 'store', 
            'showForgotPasswordForm', 'sendResetLinkEmail',
            'showResetPasswordForm', 'resetPassword'
        ]);
    }

    /**
     * Afficher la page de connexion
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Afficher la page d'inscription
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Traiter la demande d'authentification
     */
    public function authenticate(Request $request)
    {
        // Valider les données de la requête
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = $this->authRepository->login($request->all());
        
        if ($user) {
            Auth::login($user);
            $request->session()->regenerate();

            // Cas spécial pour les médecins en attente
            if ($user->isDoctor() && $user->isPending()) {
                return redirect()->route('doctor.pending')
                    ->with('warning', 'Votre compte est en attente de validation par un administrateur.');
            }
            
            // Utiliser la méthode getHomeRoute pour déterminer la redirection
            return redirect(RouteServiceProvider::getHomeRoute($user->role))
            ->with('success', 'Connexion réussie. Bienvenue !');
        } else {
           
            return redirect()->route('login')
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Ces identifiants ne correspondent pas à nos enregistrements.']);
        }
    
    }

    /**
     * Enregistrer un nouvel utilisateur
     */
    public function store(Request $request)
    {
        // Valider les données de la requête
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
            
            // Pour les autres types d'utilisateurs, connexion automatique
            Auth::login($user);
            return redirect(RouteServiceProvider::getHomeRoute($user->role))
            ->with('success', 'Votre compte a été créé avec succès.');
        }
    
        return redirect()->back()
            ->withInput()
            ->withErrors(['error' => 'Une erreur est survenue lors de la création de votre compte. Veuillez réessayer.']);
    }

    /**
     * Afficher le formulaire de demande de réinitialisation de mot de passe
     */
    public function showForgotPasswordForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Envoyer le lien de réinitialisation du mot de passe
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // On utilise le système de réinitialisation de mot de passe intégré à Laravel
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Afficher le formulaire de réinitialisation de mot de passe
     */
    public function showResetPasswordForm(Request $request, $token)
    {
        return view('auth.passwords.reset', ['token' => $token, 'email' => $request->email]);
    }

    /**
     * Réinitialiser le mot de passe
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Ici on procède à la réinitialisation du mot de passe
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

        // Redirection après la réinitialisation
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

    /**
     * Déconnecter l'utilisateur
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }

    /**
     * Afficher la page d'attente pour les médecins
     */
    public function doctorPending()
    {
        return view('auth.doctor-pending');
    }
}
<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';
    
    /**
     * Routes spécifiques pour chaque rôle d'utilisateur
     */
    public const ADMIN_HOME = '/admin/dashboard';
    public const DOCTOR_HOME = '/doctor/dashboard';
    public const PATIENT_HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
    
    /**
     * Get the home route based on user role
     * 
     * @param string $role User role
     * @return string The home route for the given role
     */
    public static function getHomeRoute($role): string
    {
        switch ($role) {
            case 'admin':
                return self::ADMIN_HOME;
            case 'doctor':
                return self::DOCTOR_HOME;
            case 'patient':
                return self::PATIENT_HOME;
            default:
                return self::HOME;
        }
    }
}

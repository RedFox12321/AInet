<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Gate;
use App\Models\Movie;
use App\Models\User;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate::policy(User::class, AdministrativePolicy::class);

        Gate::define('useCart', function (?User $user) {
            return $user === null || $user->type == 'S';
        });

        Gate::define('confirmCart', function (User $user) {
            return $user->type == 'C';
        });

        try {
            // View::share adds data (variables) that are shared through all views (like global data)
            View::share('movies', Movie::orderBy('tittle')->get());
        } catch (\Exception $e) {
            // If no Database exists, or Course table does not exist yet, an error will occour
            // This will ignore this error to avoid problems before migration is correctly executed
            // (When executing "composer update", when executing "php artisan migrate", etc)
        }
    }
}

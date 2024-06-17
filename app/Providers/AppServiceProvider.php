<?php

namespace App\Providers;

use App\Models\Screening;
use App\Policies\AdminPolicy;
use App\Policies\EmployeePolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Gate;
use App\Models\Seat;
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
        Gate::define('useCart', function (?User $user) {
            return $user === null || $user->type == 'C';
        });

        Gate::define('confirmCart', function (?User $user) {
            return $user === null || $user->type == 'C';
        });

        Gate::define('admin', function (User $user) {
            return $user->type == 'A';
        });

        try {
            // View::share adds data (variables) that are shared through all views (like global data)
            View::share('seats_g', Seat::get());
            View::share('screenings_g', Screening::get());
        } catch (\Exception $e) {
            // If no Database exists, or Course table does not exist yet, an error will occour
            // This will ignore this error to avoid problems before migration is correctly executed
            // (When executing "composer update", when executing "php artisan migrate", etc)
        }
    }
}

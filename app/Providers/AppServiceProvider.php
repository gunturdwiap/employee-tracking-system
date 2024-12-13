<?php

namespace App\Providers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Model::preventLazyLoading();

        Gate::define('access-admin-panel', function (User $user) {
            return ($user->role === UserRole::ADMIN) || ($user->role === UserRole::VERIFICATOR);
        });

        Gate::define('access-employee-menu', function (User $user) {
            return $user->role === UserRole::EMPLOYEE;
        });
    }
}

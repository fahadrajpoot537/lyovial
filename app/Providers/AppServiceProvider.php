<?php

namespace App\Providers;

use App\View\Composers\FrontLayoutComposer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        Gate::before(function ($user, string $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        Blade::if('admincan', function (string $permission) {
            return auth()->check() && auth()->user()->can($permission);
        });

        View::composer('front.*', FrontLayoutComposer::class);
    }
}

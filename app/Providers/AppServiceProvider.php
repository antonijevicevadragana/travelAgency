<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
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
        //
        Model::unguard();
        Paginator::useBootstrapFive(); 
        
        view()->composer('layouts.app', function ($view) {
            $view->with('currentLocale', App::currentLocale());
        });

        view()->composer('layouts.show', function ($view) {
            $view->with('currentLocale', App::currentLocale());
        });

        view()->composer('layouts.logreg', function ($view) {
            $view->with('currentLocale', App::currentLocale());
        });

    }
}

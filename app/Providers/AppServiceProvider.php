<?php

namespace App\Providers;

use App\User;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->isAdmin();
        });
        Blade::if('hasPosts', function () {
            return auth()->check() && ! auth()->user()->isMember();
        });
        
    }
}

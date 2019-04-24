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
        
        Blade::include('admin.components.form.input', 'input');

        Blade::if('superAdmin', function () {
            return auth()->check() && auth()->user()->isSuperAdmin() ;
        });

        Blade::if('admin', function () {
            return  auth()->check() && auth()->user()->isAdmin() ;
        });

        Blade::if('writer', function () {
            return auth()->check() && auth()->user()->isWriter() ;
        });

        Blade::if('moderator', function () {
            return auth()->check() && auth()->user()->isModerator() ;
        });
   
    }
}

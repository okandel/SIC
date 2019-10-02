<?php

namespace App\Providers\Api\v1;

use Illuminate\Support\ServiceProvider;
use App\Auth\Api\v1\UserAuthentication;

class UserAuthServiceProvider extends ServiceProvider
{

    private $request;
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Auth\Api\v1\UserAuthentication', function($app){
          return new UserAuthentication();
        });
    }
}

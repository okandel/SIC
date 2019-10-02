<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CustomServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //

        $this->app->bind('currentFirm',function(){ 
            return new \App\Helpers\CurrentFirm; 
        });
         
        $this->app->bind('settings',function(){ 
            return new \App\Helpers\Settings; 
        });


        // App::bind('encryptHelper', function() 
        // { 
        //     return new \App\Helpers\EncryptHelper; 
        // });
         
        // App::bind('currentFirm', function() 
        // { 
        //     return new \App\Helpers\CurrentFirm; 
        // });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

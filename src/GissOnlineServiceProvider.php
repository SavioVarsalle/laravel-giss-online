<?php

namespace SavioVarsalle\LaravelGissOnline;

use Illuminate\Support\ServiceProvider;
class GissOnlineServiceProvider
{
    /**
         * Register services.
         *
         * @return void
         */
    public function register()
    {
        $this->publishes([
            __DIR__.'/../config/gissonline.php' => config_path('gissonline.php'),
        ], 'gissonline-config');
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

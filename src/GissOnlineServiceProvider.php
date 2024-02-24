<?php

namespace SavioVarsalle\LaravelGissOnline;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class GissOnlineServiceProvider extends ServiceProvider
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
        $this->publishes([
            __DIR__.'/../config/gissonline.php' => config_path('gissonline.php'),
        ], 'gissonline-config');
    }
}

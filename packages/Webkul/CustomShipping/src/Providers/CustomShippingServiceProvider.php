<?php

namespace Webkul\CustomShipping\Providers;

use Illuminate\Support\ServiceProvider;

class CustomShippingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');

        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'custom-shipping');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/carriers.php',
            'carriers'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/system.php',
            'core'
        );
    }
}

<?php

namespace Webkul\CustomCommerce\Providers;

use Illuminate\Support\ServiceProvider;

class CustomCommerceServiceProvider extends ServiceProvider
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

        $this->loadRoutesFrom(__DIR__.'/../Routes/api.php');

        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'custom-commerce');

        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'custom-commerce');

        $this->app->register(EventServiceProvider::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/menu.php',
            'menu.admin'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/acl.php',
            'acl'
        );
    }
}

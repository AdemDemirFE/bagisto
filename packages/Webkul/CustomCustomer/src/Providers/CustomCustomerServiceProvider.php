<?php

namespace Webkul\CustomCustomer\Providers;

use Illuminate\Support\ServiceProvider;

class CustomCustomerServiceProvider extends ServiceProvider
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

        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'custom-customer');

        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'custom-customer');

        $this->app->register(EventServiceProvider::class);
    }
}

<?php

namespace Webkul\CustomAdmin\Providers;

use Illuminate\Support\ServiceProvider;

class CustomAdminServiceProvider extends ServiceProvider
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
    }
}

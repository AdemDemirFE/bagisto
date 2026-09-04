<?php

namespace Webkul\CustomAI\Providers;

use Illuminate\Support\ServiceProvider;

class CustomAIServiceProvider extends ServiceProvider
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

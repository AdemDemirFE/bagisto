<?php

namespace Webkul\CustomCommerce\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Webkul\CustomCommerce\Listeners\DashboardWidget;
use Webkul\Theme\ViewRenderEventManager;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen('bagisto.admin.dashboard.store_stats.after', function (ViewRenderEventManager $viewRenderEventManager) {
            app(DashboardWidget::class)->handle($viewRenderEventManager);
        });
    }
}

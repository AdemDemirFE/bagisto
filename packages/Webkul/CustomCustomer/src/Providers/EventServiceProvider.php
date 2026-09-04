<?php

namespace Webkul\CustomCustomer\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Webkul\CustomCustomer\Listeners\CustomerLoyaltyWidget;
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
        Event::listen('bagisto.admin.customers.customers.view.card.orders.before', function (ViewRenderEventManager $viewRenderEventManager) {
            app(CustomerLoyaltyWidget::class)->handle($viewRenderEventManager);
        });
    }
}

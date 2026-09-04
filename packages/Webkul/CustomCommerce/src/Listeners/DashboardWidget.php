<?php

namespace Webkul\CustomCommerce\Listeners;

use Webkul\CustomCommerce\Services\CommerceSummary;
use Webkul\Theme\ViewRenderEventManager;

class DashboardWidget
{
    /**
     * Create a listener instance.
     *
     * @return void
     */
    public function __construct(
        protected CommerceSummary $summary
    ) {}

    /**
     * Inject the overview widget into the admin dashboard.
     */
    public function handle(ViewRenderEventManager $viewRenderEventManager): void
    {
        $viewRenderEventManager->addTemplate('custom-commerce::admin.dashboard.widget', [
            'overview' => $this->summary->overview(),
        ]);
    }
}

<?php

namespace Webkul\CustomCustomer\Listeners;

use Webkul\CustomCustomer\Services\LoyaltyTier;
use Webkul\Theme\ViewRenderEventManager;

class CustomerLoyaltyWidget
{
    /**
     * Create a listener instance.
     *
     * @return void
     */
    public function __construct(
        protected LoyaltyTier $loyaltyTier
    ) {}

    /**
     * Inject the loyalty card into the admin customer view.
     */
    public function handle(ViewRenderEventManager $viewRenderEventManager): void
    {
        $customerId = (int) request()->route('id');

        if (! $customerId) {
            return;
        }

        $summary = $this->loyaltyTier->forCustomer($customerId);

        $summary['tier_label'] = $this->loyaltyTier->tierLabel($summary['tier']);

        $viewRenderEventManager->addTemplate('custom-customer::admin.customers.widget', [
            'summary' => $summary,
        ]);
    }
}

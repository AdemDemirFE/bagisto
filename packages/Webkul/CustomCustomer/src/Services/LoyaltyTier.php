<?php

namespace Webkul\CustomCustomer\Services;

use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\Sales\Repositories\OrderRepository;

class LoyaltyTier
{
    /**
     * Tier thresholds in base currency.
     */
    protected array $thresholds = [
        'altin' => 5000,
        'gumus' => 1000,
        'bronz' => 0,
    ];

    /**
     * Create a service instance.
     *
     * @return void
     */
    public function __construct(
        protected OrderRepository $orderRepository,
        protected CustomerRepository $customerRepository
    ) {}

    /**
     * Loyalty summary for the given customer.
     */
    public function forCustomer(int $customerId): array
    {
        $orders = $this->orderRepository
            ->resetModel()
            ->where('customer_id', $customerId);

        $count = (clone $orders)->count();

        $spent = (float) (clone $orders)->sum('base_grand_total');

        $tier = 'bronz';

        foreach ($this->thresholds as $name => $limit) {
            if ($spent >= $limit) {
                $tier = $name;

                break;
            }
        }

        $next = null;

        foreach (array_reverse($this->thresholds, true) as $name => $limit) {
            if ($limit > $spent) {
                $next = ['tier' => $name, 'remaining' => $limit - $spent];

                break;
            }
        }

        return [
            'customer_id' => $customerId,
            'orders' => $count,
            'spent' => $spent,
            'tier' => $tier,
            'next_tier' => $next,
        ];
    }

    /**
     * Localized tier label.
     */
    public function tierLabel(string $tier): string
    {
        return trans('custom-customer::app.loyalty.tiers.'.$tier);
    }
}

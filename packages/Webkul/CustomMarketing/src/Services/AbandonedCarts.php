<?php

namespace Webkul\CustomMarketing\Services;

use Illuminate\Database\Eloquent\Builder;
use Webkul\Checkout\Repositories\CartRepository;

class AbandonedCarts
{
    /**
     * Hours of inactivity before a cart counts as abandoned.
     */
    protected int $abandonAfterHours = 24;

    /**
     * Create a service instance.
     *
     * @return void
     */
    public function __construct(
        protected CartRepository $cartRepository
    ) {}

    /**
     * Base query for abandoned carts.
     *
     * @return Builder
     */
    public function query()
    {
        return $this->cartRepository
            ->resetModel()
            ->where('is_active', 1)
            ->where('items_count', '>', 0)
            ->where('updated_at', '<', now()->subHours($this->abandonAfterHours));
    }

    /**
     * Abandoned cart statistics.
     */
    public function stats(): array
    {
        $query = $this->query();

        return [
            'carts' => (clone $query)->count(),
            'revenue' => (float) (clone $query)->sum('base_grand_total'),
        ];
    }
}

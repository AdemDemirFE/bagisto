<?php

namespace Webkul\CustomCommerce\Services;

use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\Product\Repositories\ProductInventoryRepository;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Sales\Repositories\OrderItemRepository;
use Webkul\Sales\Repositories\OrderRepository;

class CommerceSummary
{
    /**
     * Create a service instance.
     *
     * @return void
     */
    public function __construct(
        protected OrderRepository $orderRepository,
        protected OrderItemRepository $orderItemRepository,
        protected CustomerRepository $customerRepository,
        protected ProductRepository $productRepository,
        protected ProductInventoryRepository $productInventoryRepository
    ) {}

    /**
     * Platform overview figures.
     */
    public function overview(): array
    {
        $revenue = (float) $this->orderRepository
            ->resetModel()
            ->sum('base_grand_total');

        return [
            'orders' => $this->orderRepository->resetModel()->count(),
            'revenue' => $revenue,
            'customers' => $this->customerRepository->resetModel()->count(),
            'products' => $this->productRepository->resetModel()->whereNull('parent_id')->count(),
        ];
    }

    /**
     * Best selling products by ordered quantity.
     */
    public function topProducts(int $limit = 5): array
    {
        return $this->orderItemRepository
            ->resetModel()
            ->selectRaw('product_id, sku, name, SUM(qty_ordered) as total_qty, SUM(total) as total_amount')
            ->groupBy('product_id', 'sku', 'name')
            ->orderByDesc('total_qty')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    /**
     * Latest orders.
     */
    public function recentOrders(int $limit = 5): array
    {
        return $this->orderRepository
            ->resetModel()
            ->orderByDesc('id')
            ->limit($limit)
            ->get(['id', 'increment_id', 'status', 'customer_email', 'grand_total', 'order_currency_code', 'created_at'])
            ->toArray();
    }

    /**
     * Products below the stock threshold.
     */
    public function stockAlerts(int $threshold = 10, int $limit = 5): array
    {
        return $this->productInventoryRepository
            ->resetModel()
            ->with('product:id,sku,attribute_family_id')
            ->where('qty', '<', $threshold)
            ->orderBy('qty')
            ->limit($limit)
            ->get(['id', 'product_id', 'inventory_source_id', 'qty'])
            ->toArray();
    }
}

<?php

namespace Webkul\CustomCommerce\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Webkul\CustomCommerce\Services\CommerceSummary;

class SummaryController extends Controller
{
    /**
     * Create a controller instance.
     *
     * @return void
     */
    public function __construct(
        protected CommerceSummary $summary
    ) {}

    /**
     * Commerce platform summary for BFF consumers.
     */
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'data' => [
                'overview' => $this->summary->overview(),
                'top_products' => $this->summary->topProducts(),
                'recent_orders' => $this->summary->recentOrders(),
                'stock_alerts' => $this->summary->stockAlerts(),
            ],
        ]);
    }
}

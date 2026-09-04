<?php

namespace Webkul\CustomCustomer\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Webkul\CustomCustomer\Services\LoyaltyTier;

class LoyaltyController extends Controller
{
    /**
     * Create a controller instance.
     *
     * @return void
     */
    public function __construct(
        protected LoyaltyTier $loyaltyTier
    ) {}

    /**
     * Authenticated customer's loyalty summary.
     */
    public function __invoke(): JsonResponse
    {
        $customer = auth()->guard('customer')->user();

        $summary = $this->loyaltyTier->forCustomer($customer->id);

        $summary['tier_label'] = $this->loyaltyTier->tierLabel($summary['tier']);

        return response()->json(['data' => $summary]);
    }
}

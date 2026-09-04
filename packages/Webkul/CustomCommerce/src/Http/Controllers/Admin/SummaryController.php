<?php

namespace Webkul\CustomCommerce\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\View\View;
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
     * Custom commerce overview page.
     *
     * @return View
     */
    public function index()
    {
        return view('custom-commerce::admin.summary.index', [
            'overview' => $this->summary->overview(),
            'topProducts' => $this->summary->topProducts(),
            'recentOrders' => $this->summary->recentOrders(),
            'stockAlerts' => $this->summary->stockAlerts(),
        ]);
    }
}

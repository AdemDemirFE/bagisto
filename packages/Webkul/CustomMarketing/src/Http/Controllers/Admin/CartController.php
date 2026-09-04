<?php

namespace Webkul\CustomMarketing\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Webkul\CustomMarketing\DataGrids\AbandonedCartDataGrid;
use Webkul\CustomMarketing\Services\AbandonedCarts;

class CartController extends Controller
{
    /**
     * Create a controller instance.
     *
     * @return void
     */
    public function __construct(
        protected AbandonedCarts $abandonedCarts
    ) {}

    /**
     * Abandoned carts listing.
     */
    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(AbandonedCartDataGrid::class)->process();
        }

        return view('custom-marketing::admin.carts.index', [
            'stats' => $this->abandonedCarts->stats(),
        ]);
    }
}

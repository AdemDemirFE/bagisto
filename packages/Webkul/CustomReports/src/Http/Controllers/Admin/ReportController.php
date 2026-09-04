<?php

namespace Webkul\CustomReports\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Webkul\CustomReports\DataGrids\SalesReportDataGrid;

class ReportController extends Controller
{
    /**
     * Sales report listing.
     */
    public function sales(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(SalesReportDataGrid::class)->process();
        }

        return view('custom-reports::admin.reports.sales');
    }
}

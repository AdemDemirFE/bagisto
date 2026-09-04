<?php

use Illuminate\Support\Facades\Route;
use Webkul\CustomReports\Http\Controllers\Admin\ReportController;

Route::group(['prefix' => 'admin/custom-reports', 'middleware' => ['web', 'admin']], function () {
    Route::get('ping', function () {
        return response()->json([
            'package' => 'CustomReports',
            'locale' => app()->getLocale(),
            'status' => 'ok',
        ]);
    })->name('custom-reports.ping');

    Route::get('sales', [ReportController::class, 'sales'])->name('custom-reports.admin.sales.index');
});

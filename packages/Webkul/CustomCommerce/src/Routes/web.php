<?php

use Illuminate\Support\Facades\Route;
use Webkul\CustomCommerce\Http\Controllers\Admin\SummaryController;

Route::group(['prefix' => 'admin/custom-commerce', 'middleware' => ['web', 'admin']], function () {
    Route::get('ping', function () {
        return response()->json([
            'package' => 'CustomCommerce',
            'locale' => app()->getLocale(),
            'status' => 'ok',
        ]);
    })->name('custom-commerce.ping');

    Route::get('summary', [SummaryController::class, 'index'])->name('custom-commerce.admin.summary.index');
});

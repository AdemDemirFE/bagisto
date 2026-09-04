<?php

use Illuminate\Support\Facades\Route;
use Webkul\CustomMarketing\Http\Controllers\Admin\CartController;

Route::group(['prefix' => 'admin/custom-marketing', 'middleware' => ['web', 'admin']], function () {
    Route::get('ping', function () {
        return response()->json([
            'package' => 'CustomMarketing',
            'locale' => app()->getLocale(),
            'status' => 'ok',
        ]);
    })->name('custom-marketing.ping');

    Route::get('abandoned-carts', [CartController::class, 'index'])->name('custom-marketing.admin.carts.index');
});

<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'custom-checkout'], function () {
    Route::get('ping', function () {
        return response()->json([
            'package' => 'CustomCheckout',
            'locale' => app()->getLocale(),
            'status' => 'ok',
        ]);
    })->name('custom-checkout.ping');
});

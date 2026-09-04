<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'custom-payments'], function () {
    Route::get('ping', function () {
        return response()->json([
            'package' => 'CustomPayments',
            'locale' => app()->getLocale(),
            'status' => 'ok',
        ]);
    })->name('custom-payments.ping');
});

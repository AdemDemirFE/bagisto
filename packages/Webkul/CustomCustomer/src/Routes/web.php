<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'custom-customer'], function () {
    Route::get('ping', function () {
        return response()->json([
            'package' => 'CustomCustomer',
            'locale' => app()->getLocale(),
            'status' => 'ok',
        ]);
    })->name('custom-customer.ping');
});

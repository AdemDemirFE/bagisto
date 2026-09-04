<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'custom-shipping'], function () {
    Route::get('ping', function () {
        return response()->json([
            'package' => 'CustomShipping',
            'locale' => app()->getLocale(),
            'status' => 'ok',
        ]);
    })->name('custom-shipping.ping');
});

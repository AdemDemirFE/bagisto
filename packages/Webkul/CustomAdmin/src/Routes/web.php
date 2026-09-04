<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'custom-admin'], function () {
    Route::get('ping', function () {
        return response()->json([
            'package' => 'CustomAdmin',
            'locale' => app()->getLocale(),
            'status' => 'ok',
        ]);
    })->name('custom-admin.ping');
});

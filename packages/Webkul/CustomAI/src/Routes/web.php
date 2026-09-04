<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'custom-ai'], function () {
    Route::get('ping', function () {
        return response()->json([
            'package' => 'CustomAI',
            'locale' => app()->getLocale(),
            'status' => 'ok',
        ]);
    })->name('custom-ai.ping');
});

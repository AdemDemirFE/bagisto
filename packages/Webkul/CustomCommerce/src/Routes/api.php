<?php

use Illuminate\Support\Facades\Route;
use Webkul\CustomCommerce\Http\Controllers\API\SummaryController;

Route::group(['prefix' => 'api/custom-commerce', 'middleware' => ['web', 'admin']], function () {
    Route::get('summary', SummaryController::class)->name('custom-commerce.api.summary');
});

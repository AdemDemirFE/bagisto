<?php

use Illuminate\Support\Facades\Route;
use Webkul\CustomCustomer\Http\Controllers\API\LoyaltyController;

Route::group(['prefix' => 'api/custom-customer', 'middleware' => ['web', 'shop', 'customer']], function () {
    Route::get('loyalty', LoyaltyController::class)->name('custom-customer.api.loyalty');
});

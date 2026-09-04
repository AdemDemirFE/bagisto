<?php

use function Pest\Laravel\getJson;

it('should redirect guests away from the commerce summary api', function () {
    getJson(route('custom-commerce.api.summary'))
        ->assertRedirect();
});

it('should return the commerce summary for admins', function () {
    $this->loginAsAdmin();

    getJson(route('custom-commerce.api.summary'))
        ->assertOk()
        ->assertJsonStructure([
            'data' => [
                'overview' => [
                    'orders',
                    'revenue',
                    'customers',
                    'products',
                ],
                'top_products',
                'recent_orders',
                'stock_alerts',
            ],
        ]);
});

it('should return the commerce summary page for admins', function () {
    $this->loginAsAdmin();

    $this->get(route('custom-commerce.admin.summary.index'))
        ->assertOk();
});

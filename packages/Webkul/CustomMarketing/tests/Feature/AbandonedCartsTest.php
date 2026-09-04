<?php

use Webkul\Checkout\Models\Cart;
use Webkul\CustomMarketing\Services\AbandonedCarts;

use function Pest\Laravel\getJson;

function createAbandonedCart(array $overrides = []): Cart
{
    return Cart::factory()->create(array_merge([
        'is_active' => 1,
        'items_count' => 2,
        'grand_total' => 500,
        'base_grand_total' => 500,
        'updated_at' => now()->subDays(2),
    ], $overrides));
}

it('should count abandoned carts and recoverable revenue', function () {
    createAbandonedCart();
    createAbandonedCart(['grand_total' => 700, 'base_grand_total' => 700]);
    createAbandonedCart(['updated_at' => now()]);

    $stats = app(AbandonedCarts::class)->stats();

    expect($stats['carts'])->toBe(2)
        ->and($stats['revenue'])->toEqual(1200.0);
});

it('should redirect guests away from the abandoned carts page', function () {
    $this->get(route('custom-marketing.admin.carts.index'))
        ->assertRedirect();
});

it('should return the abandoned carts page and records for admins', function () {
    $this->loginAsAdmin();

    createAbandonedCart();

    $this->get(route('custom-marketing.admin.carts.index'))
        ->assertOk()
        ->assertSee('Terk Edilmiş Sepetler');

    getJson(route('custom-marketing.admin.carts.index'), ['X-Requested-With' => 'XMLHttpRequest'])
        ->assertOk()
        ->assertJsonStructure([
            'records',
            'meta' => ['total'],
        ]);
});

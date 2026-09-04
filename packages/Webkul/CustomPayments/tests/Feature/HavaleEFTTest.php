<?php

use Webkul\Checkout\Models\Cart;
use Webkul\Checkout\Models\CartAddress;
use Webkul\Checkout\Models\CartItem;
use Webkul\Checkout\Models\CartPayment;
use Webkul\Checkout\Models\CartShippingRate;
use Webkul\Faker\Helpers\Product as ProductFaker;
use Webkul\Payment\Facades\Payment;
use Webkul\Sales\Models\Order;

use function Pest\Laravel\postJson;

it('should list havaleeft among the supported payment methods', function () {
    cart()->setCart(Cart::factory()->create());

    $methods = collect(Payment::getSupportedPaymentMethods()['payment_methods']);

    expect($methods->pluck('method'))->toContain('havaleeft');
});

it('should expose the havaleeft method as available', function () {
    cart()->setCart(Cart::factory()->create());

    $methods = collect(Payment::getSupportedPaymentMethods()['payment_methods']);

    expect($methods->contains('method', 'havaleeft'))->toBeTrue();
});

it('should place an order paid with havaleeft', function () {
    $product = (new ProductFaker)->getSimpleProductFactory()->create();

    $cart = Cart::factory()->create(['shipping_method' => 'free_free']);

    $cartItem = CartItem::factory()->create([
        'cart_id' => $cart->id,
        'product_id' => $product->id,
        'sku' => $product->sku,
        'quantity' => 1,
        'name' => $product->name,
        'price' => $convertedPrice = core()->convertPrice($price = $product->price),
        'total' => $convertedPrice,
        'base_price' => $price,
        'base_total' => $price,
        'type' => $product->type,
        'additional' => [
            'product_id' => $product->id,
            'quantity' => 1,
        ],
    ]);

    $cartBillingAddress = CartAddress::factory()->create([
        'cart_id' => $cart->id,
        'address_type' => CartAddress::ADDRESS_TYPE_BILLING,
    ]);

    $cartShippingAddress = CartAddress::factory()->create([
        'cart_id' => $cart->id,
        'address_type' => CartAddress::ADDRESS_TYPE_SHIPPING,
    ]);

    CartPayment::factory()->create([
        'cart_id' => $cart->id,
        'method' => 'havaleeft',
        'method_title' => 'Havale / EFT',
    ]);

    CartShippingRate::factory()->create([
        'carrier' => 'free',
        'carrier_title' => 'Free Shipping',
        'method' => 'free_free',
        'method_title' => 'Free Shipping',
        'method_description' => 'Free Shipping',
        'cart_address_id' => $cartShippingAddress->id,
        'cart_id' => $cart->id,
    ]);

    cart()->setCart($cart);

    cart()->collectTotals();

    postJson(route('shop.checkout.onepage.orders.store'))
        ->assertOk()
        ->assertJsonPath('data.redirect', true);

    $this->assertDatabaseHas('orders', [
        'cart_id' => $cart->id,
    ]);

    $order = Order::query()->where('cart_id', $cart->id)->firstOrFail();

    expect($order->payment->method)->toBe('havaleeft');
});

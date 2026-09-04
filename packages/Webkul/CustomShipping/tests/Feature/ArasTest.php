<?php

use Webkul\Checkout\Models\Cart;
use Webkul\Checkout\Models\CartAddress;
use Webkul\Checkout\Models\CartItem;
use Webkul\Checkout\Models\CartPayment;
use Webkul\Checkout\Models\CartShippingRate;
use Webkul\Product\Models\Product;
use Webkul\Sales\Models\Order;
use Webkul\Shipping\Facades\Shipping;

use function Pest\Laravel\postJson;

function createArasCart(int $quantity = 1): array
{
    $product = Product::query()->where('sku', 'el-android-tablet')->firstOrFail();

    $cart = Cart::factory()->create();

    $cartItem = CartItem::factory()->create([
        'cart_id' => $cart->id,
        'product_id' => $product->id,
        'sku' => $product->sku,
        'quantity' => $quantity,
        'name' => $product->name,
        'price' => $convertedPrice = core()->convertPrice($price = $product->price),
        'total' => $convertedPrice * $quantity,
        'base_price' => $price,
        'base_total' => $price * $quantity,
        'type' => $product->type,
        'additional' => [
            'product_id' => $product->id,
            'quantity' => $quantity,
        ],
    ]);

    $billing = CartAddress::factory()->create([
        'cart_id' => $cart->id,
        'address_type' => CartAddress::ADDRESS_TYPE_BILLING,
    ]);

    $shipping = CartAddress::factory()->create([
        'cart_id' => $cart->id,
        'address_type' => CartAddress::ADDRESS_TYPE_SHIPPING,
    ]);

    cart()->setCart($cart);

    cart()->collectTotals();

    return [$cart, $cartItem, $billing, $shipping];
}

it('should offer the aras standard rate', function () {
    [$cart] = createArasCart();

    $rates = Shipping::collectRates();

    $aras = collect($rates['shippingMethods']['aras']['rates'] ?? []);

    expect($aras->pluck('method'))->toContain('aras_standard')
        ->and($aras->firstWhere('method', 'aras_standard')['price'])->toEqual(49.99);
});

it('should ship free above the threshold', function () {
    [$cart] = createArasCart(3);

    $rates = Shipping::collectRates();

    $aras = collect($rates['shippingMethods']['aras']['rates'] ?? []);

    expect($aras->firstWhere('method', 'aras_standard')['price'])->toEqual(0);
});

it('should place an order shipped with aras', function () {
    [$cart, $cartItem, $billing, $shipping] = createArasCart();

    CartPayment::factory()->create([
        'cart_id' => $cart->id,
        'method' => 'cashondelivery',
        'method_title' => 'Cash On Delivery',
    ]);

    CartShippingRate::factory()->create([
        'carrier' => 'aras',
        'carrier_title' => 'Aras Kargo',
        'method' => 'aras_standard',
        'method_title' => 'Aras Kargo',
        'method_description' => 'Aras Kargo ile standart teslimat',
        'cart_address_id' => $shipping->id,
        'cart_id' => $cart->id,
    ]);

    $cart->update(['shipping_method' => 'aras_standard']);

    cart()->setCart($cart->refresh());

    cart()->collectTotals();

    postJson(route('shop.checkout.onepage.orders.store'))
        ->assertOk()
        ->assertJsonPath('data.redirect', true);

    $order = Order::query()->where('cart_id', $cart->id)->firstOrFail();

    expect($order->shipping_method)->toBe('aras_standard');
});

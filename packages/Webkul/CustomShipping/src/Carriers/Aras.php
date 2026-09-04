<?php

namespace Webkul\CustomShipping\Carriers;

use Webkul\Checkout\Facades\Cart;
use Webkul\Checkout\Models\CartShippingRate;
use Webkul\Shipping\Carriers\AbstractShipping;

class Aras extends AbstractShipping
{
    /**
     * Shipping method carrier code.
     *
     * @var string
     */
    protected $code = 'aras';

    /**
     * Shipping method code.
     *
     * @var string
     */
    protected $method = 'aras_standard';

    /**
     * Calculate rate for Aras cargo.
     *
     * @return CartShippingRate|false
     */
    public function calculate()
    {
        if (! $this->isAvailable()) {
            return false;
        }

        $cart = Cart::getCart();

        if (! $cart) {
            return false;
        }

        $cartShippingRate = new CartShippingRate;

        $cartShippingRate->carrier = $this->getCode();
        $cartShippingRate->carrier_title = $this->getConfigData('title');
        $cartShippingRate->method = $this->getMethod();
        $cartShippingRate->method_title = $this->getConfigData('title');
        $cartShippingRate->method_description = $this->getConfigData('description');

        if (
            (float) $this->getConfigData('free_threshold') > 0
            && (float) $cart->base_sub_total >= (float) $this->getConfigData('free_threshold')
        ) {
            $cartShippingRate->price = 0;
            $cartShippingRate->base_price = 0;

            return $cartShippingRate;
        }

        $cartShippingRate->price = core()->convertPrice($this->getConfigData('default_rate'));
        $cartShippingRate->base_price = $this->getConfigData('default_rate');

        return $cartShippingRate;
    }
}

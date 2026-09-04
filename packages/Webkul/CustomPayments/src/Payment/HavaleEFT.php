<?php

namespace Webkul\CustomPayments\Payment;

use Webkul\Payment\Payment\Payment;

class HavaleEFT extends Payment
{
    /**
     * Payment method code.
     *
     * @var string
     */
    protected $code = 'havaleeft';

    /**
     * Get redirect url.
     *
     * @return void
     */
    public function getRedirectUrl() {}

    /**
     * Returns payment method additional information.
     *
     * @return array
     */
    public function getAdditionalDetails()
    {
        if (empty($this->getConfigData('bank_accounts'))) {
            return [];
        }

        return [
            'title' => trans('custom-payments::app.payment.bank-accounts'),
            'value' => $this->getConfigData('bank_accounts'),
        ];
    }
}

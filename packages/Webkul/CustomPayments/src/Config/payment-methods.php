<?php

use Webkul\CustomPayments\Payment\HavaleEFT;

return [
    'havaleeft' => [
        'class' => HavaleEFT::class,
        'code' => 'havaleeft',
        'title' => 'Havale / EFT',
        'description' => 'Banka havalesi veya EFT ile ödeme',
        'active' => true,
        'generate_invoice' => false,
        'sort' => 10,
    ],
];

<?php

use Webkul\CustomShipping\Carriers\Aras;

return [
    'aras' => [
        'code' => 'aras',
        'title' => 'Aras Kargo',
        'description' => 'Aras Kargo ile standart teslimat',
        'active' => true,
        'default_rate' => '49.99',
        'free_threshold' => '1500',
        'class' => Aras::class,
    ],
];

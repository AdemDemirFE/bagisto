<?php

return [
    [
        'key' => 'sales.carriers.aras',
        'name' => 'custom-shipping::app.configuration.carrier.name',
        'info' => 'custom-shipping::app.configuration.carrier.info',
        'sort' => 3,
        'fields' => [
            [
                'name' => 'title',
                'title' => 'admin::app.configuration.index.sales.shipping-methods.flat-rate-shipping.title',
                'type' => 'text',
                'depends' => 'active:1',
                'validation' => 'required_if:active,1',
                'channel_based' => true,
                'locale_based' => true,
            ], [
                'name' => 'description',
                'title' => 'admin::app.configuration.index.sales.shipping-methods.flat-rate-shipping.description',
                'type' => 'textarea',
                'channel_based' => true,
                'locale_based' => true,
            ], [
                'name' => 'default_rate',
                'title' => 'admin::app.configuration.index.sales.shipping-methods.flat-rate-shipping.rate',
                'type' => 'text',
                'depends' => 'active:1',
                'validation' => 'required_if:active,1|numeric',
                'channel_based' => true,
                'locale_based' => false,
            ], [
                'name' => 'free_threshold',
                'title' => 'custom-shipping::app.configuration.carrier.free-threshold',
                'type' => 'text',
                'depends' => 'active:1',
                'validation' => 'numeric|min:0',
                'channel_based' => true,
                'locale_based' => false,
            ], [
                'name' => 'active',
                'title' => 'admin::app.configuration.index.sales.shipping-methods.flat-rate-shipping.status',
                'type' => 'boolean',
                'channel_based' => true,
                'locale_based' => false,
            ],
        ],
    ],
];

<?php

return [
    [
        'key' => 'sales.payment_methods.havaleeft',
        'name' => 'custom-payments::app.configuration.payment-method.name',
        'info' => 'custom-payments::app.configuration.payment-method.info',
        'sort' => 10,
        'fields' => [
            [
                'name' => 'active',
                'title' => 'admin::app.configuration.index.sales.payment-methods.status',
                'type' => 'boolean',
                'channel_based' => true,
                'locale_based' => false,
            ], [
                'name' => 'title',
                'title' => 'admin::app.configuration.index.sales.payment-methods.title',
                'type' => 'text',
                'depends' => 'active:1',
                'validation' => 'required_if:active,1',
                'channel_based' => true,
                'locale_based' => true,
            ], [
                'name' => 'description',
                'title' => 'admin::app.configuration.index.sales.payment-methods.description',
                'type' => 'textarea',
                'depends' => 'active:1',
                'channel_based' => true,
                'locale_based' => true,
            ], [
                'name' => 'generate_invoice',
                'title' => 'admin::app.configuration.index.sales.payment-methods.generate-invoice',
                'type' => 'boolean',
                'depends' => 'active:1',
                'channel_based' => true,
                'locale_based' => false,
            ], [
                'name' => 'order_status',
                'depends' => 'active:1',
                'title' => 'admin::app.configuration.index.sales.payment-methods.set-order-status',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'admin::app.configuration.index.sales.payment-methods.pending',
                        'value' => 'pending',
                    ], [
                        'title' => 'admin::app.configuration.index.sales.payment-methods.pending-payment',
                        'value' => 'pending_payment',
                    ], [
                        'title' => 'admin::app.configuration.index.sales.payment-methods.processing',
                        'value' => 'processing',
                    ],
                ],
                'channel_based' => true,
                'locale_based' => false,
            ], [
                'name' => 'bank_accounts',
                'title' => 'custom-payments::app.configuration.payment-method.bank-accounts',
                'type' => 'textarea',
                'depends' => 'active:1',
                'channel_based' => true,
                'locale_based' => false,
            ], [
                'name' => 'sort',
                'title' => 'admin::app.configuration.index.sales.payment-methods.sort-order',
                'type' => 'number',
                'depends' => 'active:1',
                'validation' => 'required_if:active,1|integer|min:1',
                'channel_based' => true,
                'locale_based' => false,
            ],
        ],
    ],
];

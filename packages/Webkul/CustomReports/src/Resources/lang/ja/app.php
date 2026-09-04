<?php

return [
    'admin' => [
        'menu' => [
            'reports' => 'Reports',
        ],
        'acl' => [
            'reports' => 'Reports',
        ],
        'reports' => [
            'sales' => [
                'title' => 'Sales Report',
                'datagrid' => [
                    'order_id' => 'Order',
                    'status' => 'Status',
                    'email' => 'Email',
                    'items' => 'Items',
                    'revenue' => 'Revenue',
                    'channel' => 'Channel',
                    'date' => 'Date',
                ],
            ],
        ],
    ],
];

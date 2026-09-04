<?php

namespace Webkul\CustomMarketing\DataGrids;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class AbandonedCartDataGrid extends DataGrid
{
    /**
     * Prepare query builder.
     *
     * @return Builder
     */
    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('cart')
            ->select(
                'cart.id',
                'cart.customer_email',
                'cart.customer_first_name',
                'cart.customer_last_name',
                'cart.items_count',
                'cart.base_grand_total',
                'cart.coupon_code',
                'cart.channel_id',
                'cart.updated_at'
            )
            ->where('cart.is_active', 1)
            ->where('cart.items_count', '>', 0)
            ->where('cart.updated_at', '<', now()->subDay());

        $this->addFilter('id', 'cart.id');
        $this->addFilter('customer_email', 'cart.customer_email');
        $this->addFilter('channel_id', 'cart.channel_id');
        $this->addFilter('updated_at', 'cart.updated_at');

        return $queryBuilder;
    }

    /**
     * Add columns.
     *
     * @return void
     */
    public function prepareColumns()
    {
        $this->addColumn([
            'index' => 'id',
            'label' => trans('custom-marketing::app.admin.carts.datagrid.id'),
            'type' => 'integer',
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'customer_email',
            'label' => trans('custom-marketing::app.admin.carts.datagrid.email'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'items_count',
            'label' => trans('custom-marketing::app.admin.carts.datagrid.items'),
            'type' => 'integer',
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'base_grand_total',
            'label' => trans('custom-marketing::app.admin.carts.datagrid.total'),
            'type' => 'decimal',
            'sortable' => true,
            'closure' => function ($row) {
                return core()->formatBasePrice($row->base_grand_total);
            },
        ]);

        $this->addColumn([
            'index' => 'coupon_code',
            'label' => trans('custom-marketing::app.admin.carts.datagrid.coupon'),
            'type' => 'string',
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'channel_id',
            'label' => trans('custom-marketing::app.admin.carts.datagrid.channel'),
            'type' => 'string',
            'filterable' => true,
            'filterable_type' => 'dropdown',
            'filterable_options' => core()->getAllChannels()
                ->map(fn ($channel) => ['label' => $channel->name, 'value' => $channel->id])
                ->values()
                ->toArray(),
            'closure' => function ($row) {
                return core()->getAllChannels()->firstWhere('id', $row->channel_id)?->name ?? $row->channel_id;
            },
        ]);

        $this->addColumn([
            'index' => 'updated_at',
            'label' => trans('custom-marketing::app.admin.carts.datagrid.updated'),
            'type' => 'date',
            'filterable' => true,
            'filterable_type' => 'date_range',
            'sortable' => true,
        ]);
    }
}

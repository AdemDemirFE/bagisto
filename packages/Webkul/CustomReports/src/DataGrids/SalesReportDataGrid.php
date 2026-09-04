<?php

namespace Webkul\CustomReports\DataGrids;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;
use Webkul\Sales\Models\Order;

class SalesReportDataGrid extends DataGrid
{
    /**
     * Prepare query builder.
     *
     * @return Builder
     */
    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('orders')
            ->leftJoin('order_items', 'orders.id', '=', 'order_items.order_id')
            ->select(
                'orders.id',
                'orders.increment_id',
                'orders.status',
                'orders.customer_email',
                'orders.channel_id',
                'orders.created_at'
            )
            ->addSelect(DB::raw('COALESCE(SUM(order_items.qty_ordered), 0) as items_qty'))
            ->addSelect(DB::raw('COALESCE(SUM(order_items.base_total), 0) as revenue'))
            ->groupBy('orders.id');

        $this->addFilter('increment_id', 'orders.increment_id');
        $this->addFilter('status', 'orders.status');
        $this->addFilter('customer_email', 'orders.customer_email');
        $this->addFilter('channel_id', 'orders.channel_id');
        $this->addFilter('created_at', 'orders.created_at');

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
            'index' => 'increment_id',
            'label' => trans('custom-reports::app.admin.reports.sales.datagrid.order_id'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => trans('custom-reports::app.admin.reports.sales.datagrid.status'),
            'type' => 'string',
            'filterable' => true,
            'filterable_type' => 'dropdown',
            'filterable_options' => [
                ['label' => trans('admin::app.sales.orders.index.datagrid.pending'), 'value' => Order::STATUS_PENDING],
                ['label' => trans('admin::app.sales.orders.index.datagrid.processing'), 'value' => Order::STATUS_PROCESSING],
                ['label' => trans('admin::app.sales.orders.index.datagrid.completed'), 'value' => Order::STATUS_COMPLETED],
                ['label' => trans('admin::app.sales.orders.index.datagrid.canceled'), 'value' => Order::STATUS_CANCELED],
                ['label' => trans('admin::app.sales.orders.index.datagrid.closed'), 'value' => Order::STATUS_CLOSED],
            ],
            'sortable' => true,
            'closure' => function ($row) {
                return match ($row->status) {
                    Order::STATUS_COMPLETED => '<p class="label-active">'.trans('admin::app.sales.orders.index.datagrid.completed').'</p>',
                    Order::STATUS_CANCELED => '<p class="label-canceled">'.trans('admin::app.sales.orders.index.datagrid.canceled').'</p>',
                    Order::STATUS_CLOSED => '<p class="label-closed">'.trans('admin::app.sales.orders.index.datagrid.closed').'</p>',
                    Order::STATUS_PROCESSING => '<p class="label-processing">'.trans('admin::app.sales.orders.index.datagrid.processing').'</p>',
                    default => '<p class="label-pending">'.trans('admin::app.sales.orders.index.datagrid.pending').'</p>',
                };
            },
        ]);

        $this->addColumn([
            'index' => 'customer_email',
            'label' => trans('custom-reports::app.admin.reports.sales.datagrid.email'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'items_qty',
            'label' => trans('custom-reports::app.admin.reports.sales.datagrid.items'),
            'type' => 'integer',
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'revenue',
            'label' => trans('custom-reports::app.admin.reports.sales.datagrid.revenue'),
            'type' => 'decimal',
            'sortable' => true,
            'closure' => function ($row) {
                return core()->formatBasePrice($row->revenue);
            },
        ]);

        $this->addColumn([
            'index' => 'channel_id',
            'label' => trans('custom-reports::app.admin.reports.sales.datagrid.channel'),
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
            'index' => 'created_at',
            'label' => trans('custom-reports::app.admin.reports.sales.datagrid.date'),
            'type' => 'date',
            'filterable' => true,
            'filterable_type' => 'date_range',
            'sortable' => true,
        ]);
    }

    /**
     * Prepare actions.
     *
     * @return void
     */
    public function prepareActions()
    {
        if (bouncer()->hasPermission('sales.orders.view')) {
            $this->addAction([
                'icon' => 'icon-view',
                'title' => trans('admin::app.sales.orders.index.datagrid.view'),
                'method' => 'GET',
                'url' => function ($row) {
                    return route('admin.sales.orders.view', $row->id);
                },
            ]);
        }
    }
}

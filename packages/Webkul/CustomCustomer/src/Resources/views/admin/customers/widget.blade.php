<div class="p-5 bg-white rounded-lg border border-slate-200 dark:bg-gray-900 dark:border-gray-800">
    <p class="mb-3 text-base font-semibold text-gray-800 dark:text-white">@lang('custom-customer::app.admin.widget.title')</p>

    <div class="flex items-center justify-between py-1.5">
        <span class="text-sm text-gray-600 dark:text-gray-300">@lang('custom-customer::app.admin.widget.tier')</span>
        <span class="label-active">{{ $summary['tier_label'] }}</span>
    </div>

    <div class="flex items-center justify-between py-1.5">
        <span class="text-sm text-gray-600 dark:text-gray-300">@lang('custom-customer::app.admin.widget.orders')</span>
        <span class="text-sm font-semibold text-gray-800 dark:text-white">{{ $summary['orders'] }}</span>
    </div>

    <div class="flex items-center justify-between py-1.5">
        <span class="text-sm text-gray-600 dark:text-gray-300">@lang('custom-customer::app.admin.widget.spent')</span>
        <span class="text-sm font-semibold text-gray-800 dark:text-white">{{ core()->formatBasePrice($summary['spent']) }}</span>
    </div>
</div>

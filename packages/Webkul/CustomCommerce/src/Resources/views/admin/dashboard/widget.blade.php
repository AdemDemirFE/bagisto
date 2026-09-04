<div class="grid grid-cols-4 gap-2.5 mt-2.5 max-lg:grid-cols-2">
    <div class="px-5 py-4 bg-white rounded-lg border border-slate-200 dark:bg-gray-900 dark:border-gray-800">
        <p class="text-sm text-gray-600 dark:text-gray-300">@lang('custom-commerce::app.admin.widget.orders')</p>
        <p class="mt-1 text-2xl font-bold text-gray-800 dark:text-white">{{ $overview['orders'] }}</p>
    </div>

    <div class="px-5 py-4 bg-white rounded-lg border border-slate-200 dark:bg-gray-900 dark:border-gray-800">
        <p class="text-sm text-gray-600 dark:text-gray-300">@lang('custom-commerce::app.admin.widget.revenue')</p>
        <p class="mt-1 text-2xl font-bold text-gray-800 dark:text-white">{{ core()->formatBasePrice($overview['revenue']) }}</p>
    </div>

    <div class="px-5 py-4 bg-white rounded-lg border border-slate-200 dark:bg-gray-900 dark:border-gray-800">
        <p class="text-sm text-gray-600 dark:text-gray-300">@lang('custom-commerce::app.admin.widget.customers')</p>
        <p class="mt-1 text-2xl font-bold text-gray-800 dark:text-white">{{ $overview['customers'] }}</p>
    </div>

    <div class="px-5 py-4 bg-white rounded-lg border border-slate-200 dark:bg-gray-900 dark:border-gray-800">
        <p class="text-sm text-gray-600 dark:text-gray-300">@lang('custom-commerce::app.admin.widget.products')</p>
        <p class="mt-1 text-2xl font-bold text-gray-800 dark:text-white">{{ $overview['products'] }}</p>
    </div>
</div>

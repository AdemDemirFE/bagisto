<x-admin::layouts>
    <x-slot:title>
        @lang('custom-commerce::app.admin.summary.title')
    </x-slot>

    <div class="flex items-center justify-between gap-4 mb-5 max-sm:flex-wrap">
        <div class="grid gap-1.5">
            <p class="text-xl font-bold !leading-normal text-gray-800 dark:text-white" v-pre>
                @lang('custom-commerce::app.admin.summary.title')
            </p>

            <p class="!leading-normal text-gray-600 dark:text-gray-300">
                @lang('custom-commerce::app.admin.summary.subtitle')
            </p>
        </div>
    </div>

    <div class="grid grid-cols-4 gap-2.5 max-lg:grid-cols-2">
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

    <div class="grid grid-cols-2 gap-2.5 mt-2.5 max-lg:grid-cols-1">
        <div class="p-5 bg-white rounded-lg border border-slate-200 dark:bg-gray-900 dark:border-gray-800">
            <p class="mb-3 text-base font-semibold text-gray-800 dark:text-white">@lang('custom-commerce::app.admin.summary.top_products')</p>

            @foreach ($topProducts as $product)
                <div class="flex items-center justify-between py-1.5 border-b border-slate-100 dark:border-gray-800 last:border-0">
                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ $product['name'] ?? $product['sku'] }}</span>
                    <span class="text-sm font-semibold text-gray-800 dark:text-white">{{ $product['total_qty'] }}</span>
                </div>
            @endforeach
        </div>

        <div class="p-5 bg-white rounded-lg border border-slate-200 dark:bg-gray-900 dark:border-gray-800">
            <p class="mb-3 text-base font-semibold text-gray-800 dark:text-white">@lang('custom-commerce::app.admin.summary.stock_alerts')</p>

            @forelse ($stockAlerts as $alert)
                <div class="flex items-center justify-between py-1.5 border-b border-slate-100 dark:border-gray-800 last:border-0">
                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ $alert['product']['sku'] ?? '#' }}</span>
                    <span class="text-sm font-semibold text-red-600">{{ $alert['qty'] }}</span>
                </div>
            @empty
                <p class="text-sm text-gray-500">@lang('custom-commerce::app.admin.summary.no_alerts')</p>
            @endforelse
        </div>
    </div>
</x-admin::layouts>

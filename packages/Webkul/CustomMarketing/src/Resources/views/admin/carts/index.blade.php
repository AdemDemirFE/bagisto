<x-admin::layouts>
    <x-slot:title>
        @lang('custom-marketing::app.admin.carts.title')
    </x-slot>

    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
        <p class="py-3 text-xl font-bold text-gray-800 dark:text-white">
            @lang('custom-marketing::app.admin.carts.title')
        </p>

        <x-admin::datagrid.export src="{{ route('custom-marketing.admin.carts.index') }}" />
    </div>

    <div class="grid grid-cols-2 gap-2.5 mb-2.5 max-lg:grid-cols-1">
        <div class="px-5 py-4 bg-white rounded-lg border border-slate-200 dark:bg-gray-900 dark:border-gray-800">
            <p class="text-sm text-gray-600 dark:text-gray-300">@lang('custom-marketing::app.admin.carts.abandoned')</p>
            <p class="mt-1 text-2xl font-bold text-gray-800 dark:text-white">{{ $stats['carts'] }}</p>
        </div>

        <div class="px-5 py-4 bg-white rounded-lg border border-slate-200 dark:bg-gray-900 dark:border-gray-800">
            <p class="text-sm text-gray-600 dark:text-gray-300">@lang('custom-marketing::app.admin.carts.recoverable')</p>
            <p class="mt-1 text-2xl font-bold text-gray-800 dark:text-white">{{ core()->formatBasePrice($stats['revenue']) }}</p>
        </div>
    </div>

    {!! view_render_event('custom-marketing.admin.carts.list.before') !!}

    <x-admin::datagrid :src="route('custom-marketing.admin.carts.index')" />

    {!! view_render_event('custom-marketing.admin.carts.list.after') !!}
</x-admin::layouts>

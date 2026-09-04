<x-admin::layouts>
    <x-slot:title>
        @lang('custom-reports::app.admin.reports.sales.title')
    </x-slot>

    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
        <p class="py-3 text-xl font-bold text-gray-800 dark:text-white">
            @lang('custom-reports::app.admin.reports.sales.title')
        </p>

        <x-admin::datagrid.export src="{{ route('custom-reports.admin.sales.index') }}" />
    </div>

    {!! view_render_event('custom-reports.admin.sales.list.before') !!}

    <x-admin::datagrid :src="route('custom-reports.admin.sales.index')" />

    {!! view_render_event('custom-reports.admin.sales.list.after') !!}
</x-admin::layouts>

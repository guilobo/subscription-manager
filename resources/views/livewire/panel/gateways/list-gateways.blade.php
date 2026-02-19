<div>

    <x-header
        :title="__('Gatways')"
        {{--        :subtitle="__('course.msg_explain_Clients')"--}}
        separator
    >
        <x-slot:middle class="!justify-end">
            {{--            <x-mary-input icon="o-bolt" placeholder="Search..." />--}}
        </x-slot:middle>
        <x-slot:actions>
            @can('access-admin-panel')
                <x-button
                    :label="__('New Gateway')"
                    icon="o-plus"
                    class="btn-primary"
                    :link="route('panel.gateways.create')"
                />
            @endcan
        </x-slot:actions>
    </x-header>
    <x-table
        :headers="$headers"
        :rows="$gatways"
        with-pagination
        per-page="perPage"
        :per-page-values="[3, 5, 10]"
    >



        @can('access-admin-panel')
            {{-- Special `actions` slot --}}
            @scope('cell_status', $gatways)
        <x-status-badge :status-id="$gatways->status_id" />

            @endscope
            @scope('actions', $gatways)
            <x-mary-button
                icon="o-pencil-square"
                :link="route('panel.gateways.edit', $gatways->id)"
                spinner
                class="btn-sm" />
            @endscope
        @endcan

        <x-slot:empty>
            <x-mary-icon name="o-cube" :label="__('It is empty.')" />
        </x-slot:empty>
    </x-table>

</div>

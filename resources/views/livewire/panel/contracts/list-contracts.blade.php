<div>

    <x-header
        :title="__('Contracts')"
        {{--        :subtitle="__('course.msg_explain_Clients')"--}}
        separator
    >
        <x-slot:middle class="!justify-end">
            {{--            <x-mary-input icon="o-bolt" placeholder="Search..." />--}}
        </x-slot:middle>
        <x-slot:actions>
            @can('access-admin-panel')
                <x-button
                    :label="__('New Contract')"
                    icon="o-plus"
                    class="btn-primary"
                    :link="route('panel.contracts.create')"
                />
            @endcan
        </x-slot:actions>
    </x-header>
    <x-table
        :headers="$headers"
        :rows="$contracts"
        with-pagination
        per-page="perPage"
        :per-page-values="[3, 5, 10]"
    >



        @can('access-admin-panel')
            {{-- Special `actions` slot --}}
            @scope('actions', $contracts)
            <x-mary-button
                icon="o-pencil-square"
                :link="route('panel.contract.edit', $contracts->id)"
                spinner
                class="btn-sm" />
            @endscope
        @endcan

        <x-slot:empty>
            <x-mary-icon name="o-cube" :label="__('It is empty.')" />
        </x-slot:empty>
    </x-table>

</div>

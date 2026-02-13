@switch(auth()->user()->role_id)
    @case(App\Models\Role::SUPER_ADM)
        <x-badge :value="__(auth()->user()->role->label)"
            {{ $attributes->class(['badge-secondary mt-2 text-white']) }}/>
        @break
    @case(App\Models\Role::ADMIN)
        <x-badge :value="__(auth()->user()->role->label)"
                      class="badge-success mt-2 text-white"/>
        @break
    @default
        <x-badge :value="__(auth()->user()->role->label)" class="badge-primary mt-2"/>
        @break
@endswitch

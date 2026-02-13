<div>
    <div class="fixed top-4 right-4 z-50">
        @foreach($toasts as $key => $toast)
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, {{ $toast['timeout'] ?? 3000 }})"
                x-show="show"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-2"
                @if(!$loop->last) class="mb-2" @endif
            >
                <x-alert
                    :title="$toast['title']"
                    :icon="$toast['icon']"
                    class="{{ $toast['css'] }}"
                />
            </div>
        @endforeach
    </div>
</div>

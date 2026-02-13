<?php

namespace App\Livewire\Helpers;

use Livewire\Attributes\On;
use Livewire\Component;

class Toast extends Component
{
    public array $toasts = [];

    #[On('showToasts')]
    public function loadToast($toast)
    {
        $this->toasts[] = $toast;
        ds($this->toasts);
    }

    public function mount(): void
    {
        if (session()->has('showToastNextPage')) {
            $this->loadToast(session('showToastNextPage'));
        }

    }

    public function render()
    {
        return view('livewire.helpers.toast');
    }
}

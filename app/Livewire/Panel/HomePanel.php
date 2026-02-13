<?php

namespace App\Livewire\Panel;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.panel')]
class HomePanel extends Component
{
    public function render()
    {
        return view('livewire.panel.home-panel');
    }
}

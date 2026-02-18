<?php

namespace App\Livewire\Panel\Contracts;

use App\Models\Client;
use App\Models\Contract;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.panel')]
class ListContracts extends Component
{
    public $perPage = 25;
    public $headers;
    public function mount(): void
    {

        $this->headers = [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => __('Name')],
        ];
    }

    public function render()
    {
        return view('livewire.panel.contracts.list-contracts')->with(
                [
                    'contracts' => Contract::paginate($this->perPage)
                ]
        );
    }
}

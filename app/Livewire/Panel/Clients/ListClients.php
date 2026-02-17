<?php

namespace App\Livewire\Panel\Clients;

use App\Models\Client;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.panel')]
class ListClients extends Component
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
        return view('livewire.panel.clients.list-clients')->with(
            [
                'clients' => Client::paginate($this->perPage)
            ]
        );
    }
}

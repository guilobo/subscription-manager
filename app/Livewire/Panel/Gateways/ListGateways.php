<?php

namespace App\Livewire\Panel\Gateways;

use App\Models\UserPaymentGateway;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.panel')]
class ListGateways extends Component
{
    public $perPage = 25;
    public $headers;
    public function mount(): void
    {

        $this->headers = [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => __('Name')],
            ['key' => 'status', 'label' => __('Status')],
        ];
    }
    public function render()
    {
        return view('livewire.panel.gateways.list-gateways')->with(
            [
                'gatways' => UserPaymentGateway::paginate($this->perPage)
            ]);
    }
}

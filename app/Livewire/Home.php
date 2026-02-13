<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Home extends Component
{

    public function mount()
    {

    }

    public function render()
    {
        return view('livewire.home');
    }
}

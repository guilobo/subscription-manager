<?php

namespace App\Livewire\Helpers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class RegisterModal extends Component
{
    public $registerModal = false;
    public $showButton = false;
    public $buttonLabel;
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);


        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        //$this->redirect(route('dashboard', absolute: false), navigate: true);
        $this->redirectIntended(default:request()->header('Referer'), navigate: true);
    }

    public function render()
    {
        return view('livewire.helpers.register-modal');
    }
}

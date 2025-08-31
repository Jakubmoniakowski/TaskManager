<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        //$this->validate(); // <<< DODAJ TO

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(
            default: route('dashboard', absolute: false),
            navigate: true
        );
    }
};
?>

<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6">Zaloguj się</h2>

        <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

        <form wire:submit.prevent="login" novalidate class="space-y-6">

            <div>
                <x-input-label for="email" :value="__('E-mail')" class="text-lg" />
                <x-text-input wire:model.live="form.email" id="email" class="block mt-2 w-full text-lg p-3 border rounded-lg" type="text" name="email" autocomplete="username"/>
                <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-center" />
            </div>

            <div>
                <x-input-label for="password" :value="__('Hasło')" class="text-lg" />
                <x-text-input wire:model.live="form.password" id="password" class="block mt-2 w-full text-lg p-3 border rounded-lg" type="password" name="password" autocomplete="current-password"/>
                <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-center" />
            </div>

            <div class="flex justify-center">
                <x-primary-button class="px-6 py-3 text-lg w-full">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>

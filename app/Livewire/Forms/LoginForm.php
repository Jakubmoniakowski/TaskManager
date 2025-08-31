<?php

namespace App\Livewire\Forms;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LoginForm extends Form
{
    #[Validate('required|string')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    /**
     * Próba logowania
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (empty($this->email) || empty($this->password)) {
            throw ValidationException::withMessages([
                'form.password' => 'Podane dane logowania są nieprawidłowe.',
            ]);
        }

        if (! Auth::attempt($this->only(['email', 'password']))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'form.password' => 'Podane dane logowania są nieprawidłowe.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'form.email' => "Zbyt wiele prób logowania. Spróbuj ponownie za {$seconds} sekund.",
        ]);
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}

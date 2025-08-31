<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Podaj imię',
            'email.required' => 'Podaj adres e-mail',
            'email.email' => 'Adres e-mail jest niepoprawny',
            'email.unique' => 'Podany adres e-mail jest już zajęty',
            'password.required' => 'Podaj hasło',
            'password.min' => 'Hasło musi mieć co najmniej :min znaków',
            'password.confirmed' => 'Hasła muszą się zgadzać',
        ];
    }
}

<?php

namespace App\Http\Requests\User\Login;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email'    => ['required', 'email'],
            'password' => ['required', 'string']
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'Введите адрес электронной почты',
            'email.email'       => 'Введите корректный адрес электронной почты',

            'password.required' => 'Введите пароль',
            'password.string'   => 'Пароль введён некорректно'
        ];
    }
}

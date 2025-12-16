<?php

namespace App\Http\Requests\User\Registration;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['required', 'string', 'max:20']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'Введите имя',
            'name.string'    => 'Имя должно быть строкой',
            'name.max'       => 'Имя не должно превышать 255 символов',

            'email.required' => 'Введите адрес электронной почты',
            'email.email'    => 'Введите корректный адрес электронной почты',
            'email.unique'   => 'Пользователь с такой почтой уже зарегистрирован',

            'password.required' => 'Введите пароль',
            'password.max'       => 'Пароль не должен быть меньше 8 символов',

            'phone.required' => 'Введите номер телефона',
            'phone.string'   => 'Номер телефона должен быть строкой',
            'phone.max'      => 'Номер телефона не должен превышать 20 символов'
        ];
    }
}

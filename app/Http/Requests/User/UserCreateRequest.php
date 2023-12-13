<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserCreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'firstName' => [
                'string'
            ],
            'lastName' => [
                'string'
            ],
            'gender' => [
                'string',
                'in:Female,Male,Unknown animal'
            ],
            'phone' => [
                'string'
            ],
            'currentAddress' => [
                'string'
            ],
            'permanantAddress' => [
                'string'
            ],
            'email' => [
                'required',
                'unique:users',
                'email'
            ],
            'birthday' => [
                'date'
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(3)
                    ->numbers()
            ],
            'remember_me' => [
                'boolean'
            ]
        ];
    }
}

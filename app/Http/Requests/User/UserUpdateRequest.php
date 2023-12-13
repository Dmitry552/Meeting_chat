<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
                'unique:users',
                'email'
            ],
            'birthday' => [
                'date'
            ],
        ];
    }
}

<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => [
                'string'
            ],
            'email' => [
                'email',
                'unique:users'
            ]
        ];
    }
}

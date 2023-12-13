<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserPasswordRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'oldPassword' => [
                'required',
                Password::min(3)
                    ->numbers()
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(3)
                    ->numbers()
            ]
        ];
    }
}

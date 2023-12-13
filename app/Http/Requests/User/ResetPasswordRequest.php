<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'token' => 'required',
            'email' => [
                'required',
                'email'
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

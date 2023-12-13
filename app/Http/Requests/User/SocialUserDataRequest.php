<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SocialUserDataRequest extends FormRequest
{
    private array $providers = [
        'google',
        'facebook'
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'provider' => [
                'required',
                Rule::in($this->providers)
            ],
            'token' => 'required_without:code',
            'code' => 'required_without:token',
        ];
    }
}

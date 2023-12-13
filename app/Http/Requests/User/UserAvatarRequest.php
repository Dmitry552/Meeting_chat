<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserAvatarRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'avatar' => [
                'required',
                'mimes:jpg,bmp,png,jpeg',
                'max:2048'
            ]
        ];
    }
}

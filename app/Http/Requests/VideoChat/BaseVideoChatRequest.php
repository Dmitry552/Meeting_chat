<?php

namespace App\Http\Requests\VideoChat;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseVideoChatRequest extends FormRequest
{
    public function rules()
    {
        return [
            'interlocutorCode' => [
                'required',
                'string'
            ]
        ];
    }
}

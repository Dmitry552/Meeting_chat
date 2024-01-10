<?php

namespace App\Http\Requests\VideoChat;

class MuteRequest extends BaseVideoChatRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                'value' => [
                    'required',
                    'boolean'
                ],
                'key' => [
                    'required',
                    'string',
                    'in:audio,video'
                ]
            ]
        );
    }
}

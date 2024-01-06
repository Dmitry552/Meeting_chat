<?php

namespace App\Http\Requests\VideoChat;

class RelaySdpRequest extends BaseVideoChatRequest
{
    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                'sessionDescription' => [
                    'required'
                ]
            ]
        );
    }
}

<?php

namespace App\Http\Requests\VideoChat;

class RelayIceRequest extends BaseVideoChatRequest
{
    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                'iceCandidate' => [
                    'required'
                ]
            ]
        );
    }
}

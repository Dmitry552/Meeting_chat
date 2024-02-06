<?php

namespace App\Http\Requests\Message;

use Illuminate\Foundation\Http\FormRequest;

class MessageGetRequest extends FormRequest
{
    private const DEFAULT_LIMIT = 100;

    public function all($keys = null): array
    {

        $data = parent::all($keys);

        isset($data['limit']) || $data['limit'] = self::DEFAULT_LIMIT;

        return $data;
    }

    public function rules()
    {
        return [
            'limit' => [
                'int',
                'min:1'
            ]
        ];
    }
}

<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserGetRequest extends FormRequest
{
    private const DEFAULT_LIMIT = 10;

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

<?php

namespace App\Http\Requests\System\Room;

use Illuminate\Foundation\Http\FormRequest;

class RoomsBetweenDatesRequest extends FormRequest
{
    public function rules()
    {
        return [
            'startDate' => [
                'required_without:endDate',
                'date'
            ],
            'endDate' => [
                'required_without:startDate',
                'date'
            ]
        ];
    }
}

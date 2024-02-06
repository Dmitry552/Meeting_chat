<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'interlocutor' => new InterlocutorResource($this->interlocutor),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

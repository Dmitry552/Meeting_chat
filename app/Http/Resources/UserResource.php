<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'currentAddress' => $this->currentAddress,
            'permanantAddress' => $this->permanantAddress,
            'email' => $this->email,
            'birthday' => $this->birthday,
            'email_verified' => isset($this->emil_verified_at),
            'avatarPath' => $this->avatarPath ? asset('storage/'.$this->avatarPath) : null,
            'roles' => $this->roles()->pluck('name'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

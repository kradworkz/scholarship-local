<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'role' => $this->role,
            'is_active' => $this->is_active,
            'firstname' => $this->profile->firstname,
            'lastname' => $this->profile->lastname,
            'middlename' => $this->profile->middlename,
            'suffix' => $this->profile->suffix,
            'gender' => $this->profile->gender,
            'mobile' => $this->profile->mobile,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

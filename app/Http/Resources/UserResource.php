<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'name'  => $this->name ?? null,
            'email'  => $this->email ?? null,
            'phone'  => $this->phone ?? null,
            'description'   => $this->description ?? null,
            'role_id'   => $this->role_id ?? null,
            'role_name'   => $this->role->name ?? null,
            'profile_image'     => asset('storage/' . $this->profile_image) ?? null,
        ];
    }
}

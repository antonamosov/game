<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'coins' => (int) $this->coins,
            'points' => (int) $this->points,
            'image' => $this->hasImage() ?  $this->image()->url('') : $this->image_path,
            'password' => $this->encrypt_password ? decrypt($this->encrypt_password) : false,
         ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PackResource extends Resource
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
            'coins_price' => $this->coins_price,
            'price' => $this->price,
            'image' => $this->image()->url(''),
            'categories' => CategoryResource::collection($this->Categories)
        ];
    }
}

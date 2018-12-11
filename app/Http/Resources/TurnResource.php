<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class TurnResource extends Resource
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
            'number' => (int) $this->number,
            'status' => $this->status,
            'user_id' => (int) $this->user_id
        ];
    }
}

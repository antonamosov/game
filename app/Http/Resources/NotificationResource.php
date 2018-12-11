<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class NotificationResource extends Resource
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
            'user' => $this->Game->User->name,
            'time' => $this->getTimePeriodAfterCreated(),
            'status' => $this->status,
            'user_image' => '',//$this->User->firstImage()->url(),
            'category' => $this->Game->Category->name
        ];
    }
}

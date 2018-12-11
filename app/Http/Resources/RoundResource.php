<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class RoundResource extends Resource
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
            'user_turns' => TurnResource::collection($this->Turns()->user($this->Game->getUser()->id)->orderByNumber()->get()),
            'opponent_turns' => TurnResource::collection($this->Turns()->user($this->Game->getOpponent()->id)->orderByNumber()->get()),
        ];
    }
}

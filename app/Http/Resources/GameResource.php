<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class GameResource extends Resource
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
            'opponent_image' => (string) $this->getOpponent()->image()->url(''),
            'opponent_name' => (string) $this->getOpponent()->name,
            'user_image' => (string) $this->getUser()->image()->url(''),
            'user_name' => (string) $this->getUser()->name,
            'category_name' => (string) $this->Category->name,
            'last_activity' => (string) $this->getLastActivity(),
            'user_turn' => getUserId() === (int) $this->user_turn_id,
            'status' => (string) $this->status,
            'rounds' => RoundResource::collection($this->Rounds()->orderByNumber()->get()),
            'user_glasses' =>  (int) ($this->authenticatedUserIsOwner() ? $this->user_glasses : $this->opponent_glasses),
            'opponent_glasses' => (int) ($this->authenticatedUserIsOwner() ? $this->opponent_glasses : $this->user_glasses),
            'round_number' => (int) $this->round_number,
            'turn_number' => (int) $this->turn_number,
            'earned_coins' => (int) $this->earned_coins,
            'victory' => getUserId() === (int) $this->winner_id,
        ];
    }
}

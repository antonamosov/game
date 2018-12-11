<?php

namespace App\Http\Resources;

use App\Services\GameService;
use Illuminate\Http\Resources\Json\Resource;

class TrainingResource extends Resource
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
            'category_name' => (string) $this->Category->name,
            'category_image' => (string) $this->Category->image()->url(''),
            'last_activity' => (string) $this->getLastActivity(),
            'status' => (string) $this->status,
            'answered_questions' => (int) $this->turn_number - 1,
            'count_of_turns' => GameService::MAX_TRAINING_QUESTIONS,
            'turns' => TurnResource::collection($this->Turns()->orderByNumber()->get()),
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AnsweredQuestion
 *
 * @property int $id
 * @property int $game_id
 * @property int $question_id
 * @mixin \Eloquent
 */
class AnsweredQuestion extends Model
{
    protected $fillable = [
        'game_id',
        'question_id'
    ];
}

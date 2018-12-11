<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    protected $fillable = [
        'game_id',
        'number'
    ];

    public function Turns()
    {
        return $this->hasMany(Turn::class);
    }

    public function Game()
    {
        return $this->belongsTo(Game::class);
    }

    public function setTurn($answerIsRight, $userId, $turnNumber)
    {
        $this->Turns()->user($userId)->number($turnNumber)->first()->setAnswer($answerIsRight);
    }

    public function scopeNumber($query, $number)
    {
        return $query->where('number', $number);
    }

    public function scopeOrderByNumber($query)
    {
        return $query->orderBy('number', 'asc');
    }
}

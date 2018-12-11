<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turn extends Model
{
    protected $fillable = [
        'status',
        'number',
        'round_id',
        'user_id',
        'game_id'
    ];

    const STATUS_EMPTY = 'empty';
    const STATUS_RIGHT = 'right';
    const STATUS_WRONG = 'wrong';

    public function scopeUser($query, $id)
    {
        return $query->where('user_id', $id);
    }

    public function scopeNumber($query, $number)
    {
        return $query->where('number', $number);
    }

    public function setAnswer($right)
    {
        $this->update([
            'status' => $right ? self::STATUS_RIGHT : self::STATUS_WRONG
        ]);
    }

    public function scopeOrderByNumber($query)
    {
        return $query->orderBy('number', 'asc');
    }
}

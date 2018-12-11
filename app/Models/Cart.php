<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'data',
        'status'
    ];

    const STATUS_WAITING = 'waiting';
    const STATUS_PAID = 'paid';

    public function scopeNotPaid($query)
    {
        return $query->where('status', self::STATUS_WAITING);
    }

}

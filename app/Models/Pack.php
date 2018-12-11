<?php

namespace App\Models;

use App\Images\ImagesTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Pack
 *
 * @property int $id
 * @property int $coins_price
 * @property string $name
 * @property string $price
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pack whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pack whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pack whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pack wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pack whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Pack extends Model
{
    use ImagesTrait;

    protected $fillable = [
        'name',
        'price',
        'coins_price'
    ];

    public function Categories()
    {
        return $this->belongsToMany(Category::class);
    }
}

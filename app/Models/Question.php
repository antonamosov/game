<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Question
 *
 * @property int $id
 * @property string $title
 * @property string $type
 * @property int $category_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Answer[] $Answers
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Question whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Question extends Model
{
    const TYPE_SELECT = 'select';
    const TYPE_TEXT = 'text';

    protected $fillable = [
        'title',
        'type',
        'category_id',
    ];

    public function Answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }

    public function isSelectType()
    {
        return $this->type === self::TYPE_SELECT;
    }
}

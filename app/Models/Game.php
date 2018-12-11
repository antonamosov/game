<?php

namespace App\Models;

use App\Events\GameActivated;
use App\Events\GameCreated;
use App\Events\GameFinished;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Game
 *
 * @property int $id
 * @property int $category_id
 * @property int $user_turn_id
 * @property int $user_id
 * @property int $opponent_id
 * @property int $question_id
 * @property bool $user_answered
 * @property bool $opponent_answered
 * @property string $status
 * @property string $type
 * @property int|null $answer_id
 * @property int|null $round_number
 * @property int|null $turn_number
 * @property int $user_glasses
 * @property int $opponent_glasses
 * @property int $winner_id
 * @property int $loser_id
 * @property int $earned_coins
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Category $Category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Notification[] $Notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AnsweredQuestion[] $AnsweredQuestions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Turn[] $Turns
 * @property-read \App\Models\User $Opponent
 * @property-read \App\Models\User $User
 * @property-read \App\Models\User $Winner
 * @property-read \App\Models\User $Loser
 * @property-read \App\Models\Question $Question
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game game()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game training()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game whereAnswerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game whereOpponentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game whereRoundId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Game whereUserTurnId($value)
 * @mixin \Eloquent
 */
class Game extends Model
{
    protected $fillable = [
        'user_id',
        'opponent_id',
        'category_id',
        'user_turn_id',
        'status',
        'question_id',
        'user_answered',
        'opponent_answered',
        'round_number',
        'turn_number',
        'user_glasses',
        'opponent_glasses',
        'earned_coins',
        'winner_id',
        'loser_id',
        'type',
    ];

    const STATUS_ACTIVE = 'active';
    const STATUS_WAITING = 'waiting';
    const STATUS_FINISHED = 'finished';

    const TYPE_GAME = 'game';
    const TYPE_TRAINING = 'training';


    public static function boot()
    {
        parent::boot();

        static::created(function (Game $game) {
            event(new GameCreated($game));
        });
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Opponent()
    {
        return $this->BelongsTo(User::class, 'opponent_id');
    }

    public function Winner()
    {
        return $this->BelongsTo(User::class, 'winner_id');
    }

    public function Loser()
    {
        return $this->BelongsTo(User::class, 'loser_id');
    }

    public function Category()
    {
        return $this->BelongsTo(Category::class);
    }

    public function Question()
    {
        return $this->belongsTo(Question::class);
    }

    public function Notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function Round()
    {
        return $this->hasOne(Round::class);
    }

    public function Rounds()
    {
        return $this->hasMany(Round::class);
    }

    public function Turns()
    {
        return $this->hasMany(Turn::class);
    }


    public function AnsweredQuestions()
    {
        $this->hasMany(AnsweredQuestion::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeGame($query)
    {
        return $query->where('type', self::TYPE_GAME);
    }

    public function scopeTraining($query)
    {
        return $query->where('type', self::TYPE_TRAINING);
    }

    public function getLastActivity()
    {
        $date = Carbon::createFromTimestamp(strtotime($this->updated_at));
        if ($date->isToday()) {
            $date = $date->format('H:i');
        }
        elseif ($date->isYesterday()) {
            $date = 'Yesterday';
        }
        else {
            $date = $date->format('Y-m-d');
        }

        return $date;
    }

    public function activate()
    {
        $this->update([
            'status' => self::STATUS_ACTIVE
        ]);
        event(new GameActivated($this));
    }

    public function finish()
    {
        $this->update([
            'status' => self::STATUS_FINISHED
        ]);
        event(new GameFinished($this));
    }

    public function isUserTurn()
    {
        return (int) $this->user_turn_id === (int) $this->user_id;
    }

    public function allUsersAnswered()
    {
        return $this->user_answered && $this->opponent_answered;
    }

    /**
     * @return Round
     */
    public function getCurrentRound()
    {
        return $this->Rounds()->number($this->round_number)->first();
    }

    public function getUser()
    {
        return $this->authenticatedUserIsOwner() ? $this->User : $this->Opponent;
    }

    public function getOpponent()
    {
        return $this->authenticatedUserIsOwner() ? $this->Opponent : $this->User;
    }

    public function authenticatedUserIsOwner()
    {
        return getUserId() === (int) $this->user_id;
    }

    public function isDraw()
    {
        return $this->isFinished() && ( empty($this->Winner) || empty($this->Loser) );
    }

    public function isFinished()
    {
        return $this->status === self::STATUS_FINISHED;
    }

    public function getWinnerGlasses()
    {
        if ($this->winner_id === $this->user_id) {
            return $this->user_glasses;
        }
        elseif ($this->winner_id === $this->opponent_id) {
            return $this->opponent_glasses;
        }
        else {
            return 0;
        }
    }

    public function getLoserGlasses()
    {
        if ($this->loser_id === $this->user_id) {
            return $this->user_glasses;
        }
        elseif ($this->loser_id === $this->opponent_id) {
            return $this->opponent_glasses;
        }
        else {
            return 0;
        }
    }

    public function isDoubles()
    {
        return $this->type === self::TYPE_GAME;
    }

    public function isTraining()
    {
        return $this->type === self::TYPE_TRAINING;
    }
}

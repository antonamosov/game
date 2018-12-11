<?php

namespace App\Models;

use App\Events\NotificationAccepted;
use App\Events\NotificationDeleted;
use App\Events\NotificationRejected;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Notification
 *
 * @property int $id
 * @property int $game_id
 * @property int $user_id
 * @property string $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Game $Game
 * @property-read \App\Models\User $User
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereUserId($value)
 * @mixin \Eloquent
 */
class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'game_id',
        'status'
    ];

    const STATUS_WAITING_OF_ACCEPT = 'waiting';
    const STATUS_REJECTED = 'rejected';
    const STATUS_ACCEPTED = 'accepted';

    public static function boot()
    {
        parent::boot();

        static::deleting(function (Notification $notification) {
            event(new NotificationDeleted($notification));
        });
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Game()
    {
        return $this->belongsTo(Game::class);
    }

    public function getTimePeriodAfterCreated()
    {
        $date = Carbon::createFromTimestamp(strtotime($this->created_at));
        $postfix = ' Ago';
        $now = Carbon::now();

        if ($date->isToday() && $date->greaterThan(Carbon::now()->subHour())) {

            return $date->diffInMinutes($now) . ' minutes' . $postfix;
        }
        elseif ($date->isToday() && $date->greaterThan(Carbon::now()->subDay())) {

            return $date->diffInHours($now) . ' hours' . $postfix;
        }
        elseif ($date->isYesterday()) {
            return 'Yesterday';
        }
        else {
            return $date->diffInDays($now) . ' days' . $postfix;
        }
    }

    public function accept()
    {
        $this->update([
            'status' => self::STATUS_ACCEPTED
        ]);
        event(new NotificationAccepted($this));
    }

    public function reject()
    {
        $this->update([
            'status' => self::STATUS_REJECTED
        ]);
        event(new NotificationRejected($this));
    }

    public function clearAll()
    {
        Notification::where('user_id', \Auth::user()->id)->delete();
    }

    public function isAccepted()
    {
        return $this->status === self::STATUS_ACCEPTED;
    }
}

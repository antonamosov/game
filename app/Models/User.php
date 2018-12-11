<?php

namespace App\Models;

use App\Images\ImagesTrait;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $encrypt_password
 * @property int|null $coins
 * @property int|null $points
 * @property string|null $image
 * @property string $role
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $Categories
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $Friends
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Game[] $Games
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Notification[] $Notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cart[] $Carts
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $Clients
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $Tokens
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCoins($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEncryptPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable, ImagesTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'encrypt_password',
        'coins',
        'points',
	'image_path',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';

    public function Friends()
    {
        return $this->belongsToMany(User::class, 'user_friends', 'user_id', 'friend_id');
    }

    public function Games()
    {
        return $this->hasMany(Game::class);
    }

    public function Carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function getAllGames()
    {
        return Game::where('user_id', $this->id)
            ->active()
            ->game()
            ->orWhere('opponent_id', $this->id)
            ->active()
            ->game()
            ->get();
    }

    public function getAllTrainings()
    {
        return $this->Games()->training()->active()->get();
    }

    public function Notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function Packs()
    {
        return $this->belongsToMany(Pack::class);
    }

    public function isOwner()
    {
        return \Auth::user()->id === $this->id;
    }

    public function addPoints($points)
    {
        $this->update([
            'points' => (int) $this->points + (int) $points
        ]);
    }

    public function addCoins($coins)
    {
        $this->update([
            'coins' => (int) $this->coins + (int) $coins
        ]);
    }

    public function pickUpCoins($coins)
    {
        $this->update([
            'coins' => (int) $this->coins - (int) $coins
        ]);
    }

    public function hasCoins($coins)
    {
        return (int) $this->coins > (int) $coins;
    }

    public function hasCategory($categoryId)
    {
        $categoriesCount = $this->Packs()->whereHas('categories', function($query) use ($categoryId) {
            $query->where('id', $categoryId);
        })->count();

        return $categoriesCount ? true : false;
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function scopePlayers($query)
    {
        return $query->where('role', self::ROLE_USER);
    }
}

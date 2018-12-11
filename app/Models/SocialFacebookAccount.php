<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SocialFacebookAccount
 *
 * @property int $id
 * @property string $provider_user_id
 * @property string $provider
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SocialFacebookAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SocialFacebookAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SocialFacebookAccount whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SocialFacebookAccount whereProviderUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SocialFacebookAccount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SocialFacebookAccount extends Model
{
    protected $fillable = [
        'user_id',
        'provider_user_id',
        'provider'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

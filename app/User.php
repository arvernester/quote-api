<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Sanitize email input.
     *
     * @param string $email
     */
    public function setEmailAttribute(string $email)
    {
        $this->attributes['email'] = strtolower($email);
    }

    /**
     * User has many Quote.
     *
     * @return HasMany
     */
    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }
}

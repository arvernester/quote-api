<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    protected $fillable = [
        'code',
        'name',
        'code',
        'native_name',
        'flag_path',
    ];

    /**
     * Country has many language.
     *
     * @return HasMany
     */
    public function languages(): HasMany
    {
        return $this->hasMany(Language::class);
    }
}

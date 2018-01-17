<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    protected $fillable = [
        'name',
        'image_path',
    ];

    protected $hidden = [
        'image_path',
    ];

    /**
     * Author has many quotes.
     *
     * @return HasMany
     */
    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }
}

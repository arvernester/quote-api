<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Category extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * Category has many quotes.
     *
     * @return HasMany
     */
    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }

    /**
     * Generate dropdown for option HTML.
     *
     * @return object|null
     */
    public static function dropdown(): ? Collection
    {
        return self::orderBy('name')
            ->pluck('name', 'id');
    }
}

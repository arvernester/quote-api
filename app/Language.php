<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Language extends Model
{
    protected $fillable = [
        'country_id',
        'code',
        'code_alternate',
        'name',
    ];

    protected $hidden = [
        'country_id',
    ];

    /**
     * Mutate native_name attributes.
     *
     * @return string
     */
    public function getNativeNameAttribute(): string
    {
        return ucwords($this->attributes['native_name']);
    }

    /**
     * Languages belongs to Country.
     *
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Language has many quotes.
     *
     * @return HasMany
     */
    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class)
            ->published();
    }

    /**
     * Generate language for option HTML.
     *
     * @return Collection|null
     */
    public static function dropdown(): ? Collection
    {
        return self::orderBy('name')
            ->pluck('name', 'id');
    }
}

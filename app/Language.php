<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\FormatDate;
use Illuminate\Support\Collection;

class Language extends Model
{
    use FormatDate;

    protected $fillable = [
        'country_id',
        'code',
        'name',
    ];

    protected $hidden = [
        'country_id',
    ];

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
        return $this->hasMany(Quote::class);
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

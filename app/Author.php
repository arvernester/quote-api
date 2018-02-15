<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Cviebrock\EloquentSluggable\Sluggable;

class Author extends Model
{
    use Sluggable;

    protected $fillable = [
        'slug',
        'name',
        'image_path',
    ];

    protected $hidden = [
        'image_path',
    ];

    protected $appends = [
        'full_image_path',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['name'],
            ],
            ];
    }

    /**
     * Get full path of author picture.
     *
     * @return string|null
     */
    public function getFullImagePathAttribute(): ?string
    {
        if (!empty($this->attributes['image_path'])) {
            return url(Storage::url($this->attributes['image_path']));
        }

        return null;
    }

    /**
     * Author has many quotes.
     *
     * @return HasMany
     */
    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }

    /**
     * Show latest quote from author.
     *
     * @return HasOne
     */
    public function latestQuote(): HasOne
    {
        return $this->hasOne(Quote::class)
            ->orderBy('created_at', 'DESC');
    }

    /**
     * Author has many profile in different language.
     *
     * @return HasMany
     */
    public function profiles(): HasMany
    {
        return $this->hasMany(AuthorProfile::class);
    }
}

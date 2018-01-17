<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'description',
        'path',
        'url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'full_path',
    ];

    protected $hidden = [
        'path',
    ];

    /**
     * Get full path of image banner.
     *
     * @return string
     */
    public function getFullPathAttribute(): string
    {
        return Storage::url($this->attributes['path']);
    }
}

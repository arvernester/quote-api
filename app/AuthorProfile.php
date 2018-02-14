<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuthorProfile extends Model
{
    protected $fillable = [
        'author_id',
        'language_id',
        'about',
        'image_path',
        'url',
    ];

    /**
     * Language field belongs to languages table.
     *
     * @return BelongsTo
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}

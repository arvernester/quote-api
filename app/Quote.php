<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quote extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'user_id',
        'language_id',
        'author_id',
        'text',
        'source',
        'status',
    ];

    protected $dates = [
        'deleted_at',
    ];

    protected $hidden = [
        'status',
        'user_id',
        'language_id',
        'author_id',
        'category_id',
        'deleted_at',
    ];

    /**
     * Sanitize text input.
     *
     * @param string $text
     */
    public function setTextAttribute(string $text)
    {
        if (!ends_with($text, ['.', '...', '?', '!'])) {
            $text .= '.';
        }

        $this->attributes['text'] = ucfirst($text);
    }

    /**
     * Quote belongs to Category.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Quote belongs to User.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Quote belongs to language.
     *
     * @return BelongsTo
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * Quote belongs to Author.
     *
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Filter quote using language code (alternate).
     *
     * @param object      $query
     * @param string|null $lang
     */
    public function scopeLanguage($query, ?string $lang = null)
    {
        return $query->when($lang, function ($query) use ($lang) {
            return $query->whereHas('language', function ($language) use ($lang) {
                return $language->where('code_alternate', $lang);
            });
        });
    }
}

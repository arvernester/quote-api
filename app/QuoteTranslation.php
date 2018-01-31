<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteTranslation extends Model
{
    protected $fillable = [
        'quote_id',
        'source_lang_id',
        'destination_lang_id',
        'text',
    ];

    /**
     * Quote translations belongs to Quote.
     *
     * @return BelongsTo
     */
    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class);
    }

    /**
     * Source lang belong to Language.
     *
     * @return BelongsTo
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'source_lang_id');
    }

    /**
     * Destination lang belongs to Language.
     *
     * @return BelongsTo
     */
    public function destination(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'destination_lang_id');
    }
}

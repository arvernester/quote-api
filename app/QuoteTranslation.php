<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteTranslation extends Model
{
    protected $fillable = [
        'quote_id',
        'source_lang',
        'destination_lang',
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
}

<?php

namespace App\Traits;

use Carbon\Carbon;

/**
 * Reformat created_at, updated_at, and deleted_at attributes.
 */
trait FormatDate
{
    /**
     * Reformat created at attribute.
     *
     * @return string
     */
    public function getCreatedAtAttribute(): string
    {
        return Carbon::parse($this->attributes['created_at'])->format(config('app.date_format'));
    }

    /**
     * Reformat updated at attribute.
     *
     * @return string
     */
    public function getUpdatedAtAttribute(): string
    {
        return Carbon::parse($this->attributes['created_at'])->format(config('app.date_format'));
    }
}

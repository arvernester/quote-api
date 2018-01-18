<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\FormatDate;

class Country extends Model
{
    use FormatDate;

    protected $fillable = [
        'code',
        'name',
        'native_name',
    ];

    /**
     * Country has many language.
     *
     * @return HasMany
     */
    public function languages(): HasMany
    {
        return $this->hasMany(Language::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'user_id',
        'text',
        'author',
        'source',
        'status',
    ];

    protected $dates = [
        'deleted_at',
    ];

    protected $hidden = [
        'status',
        'user_id',
        'category_id',
        'deleted_at',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

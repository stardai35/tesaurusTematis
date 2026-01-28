<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subcategory extends Model
{
    protected $table = 'subcategory';

    public $timestamps = false;

    protected $fillable = [
        'cat_id',
        'num',
        'title',
        'slug',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'subcat_id');
    }
}


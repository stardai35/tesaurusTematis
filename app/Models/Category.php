<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'category';

    public $timestamps = false;

    protected $fillable = [
        'num',
        'title',
        'slug',
    ];

    public function subcategories(): HasMany
    {
        return $this->hasMany(Subcategory::class, 'cat_id');
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'cat_id');
    }
}


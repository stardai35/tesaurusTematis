<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    protected $table = 'article';

    public $timestamps = false;

    protected $fillable = [
        'cat_id',
        'subcat_id',
        'num',
        'title',
        'slug',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class, 'subcat_id');
    }

    public function wordRelations(): HasMany
    {
        return $this->hasMany(WordRelation::class, 'article_id');
    }
}


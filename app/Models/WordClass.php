<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WordClass extends Model
{
    protected $table = 'word_class';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'abbr',
    ];

    public function wordRelations(): HasMany
    {
        return $this->hasMany(WordRelation::class, 'wordclass_id');
    }

    public function lemmas(): HasMany
    {
        return $this->hasManyThrough(
            Lemma::class,
            WordRelation::class,
            'wordclass_id',
            'id',
            'id',
            'lemma_id'
        );
    }
}


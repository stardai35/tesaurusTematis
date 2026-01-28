<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WordRelation extends Model
{
    protected $table = 'word_relation';

    public $timestamps = false;

    protected $fillable = [
        'article_id',
        'par_num',
        'wordclass_id',
        'group_num',
        'type_id',
        'word_order',
        'lemma_id',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    public function lemma(): BelongsTo
    {
        return $this->belongsTo(Lemma::class, 'lemma_id');
    }

    public function wordClass(): BelongsTo
    {
        return $this->belongsTo(WordClass::class, 'wordclass_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'type_id');
    }
}


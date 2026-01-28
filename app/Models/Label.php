<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Label extends Model
{
    protected $table = 'label';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'abbr',
    ];

    public function lemmas(): HasMany
    {
        return $this->hasMany(Lemma::class, 'label_id');
    }
}


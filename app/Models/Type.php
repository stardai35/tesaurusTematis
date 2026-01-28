<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type extends Model
{
    protected $table = 'type';

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function wordRelations(): HasMany
    {
        return $this->hasMany(WordRelation::class, 'type_id');
    }
}


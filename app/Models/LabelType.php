<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LabelType extends Model
{
    protected $table = 'label_type';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
    ];

    public function wordRelations(): HasMany
    {
        return $this->hasMany(WordRelation::class, 'relationship_type');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Lemma extends Model
{
    protected $table = 'lemma';

    public $timestamps = false;

    protected $fillable = [
        'label_id',
        'name',
        'name_tagged',
    ];

    protected $appends = [
        'slug',
    ];

    public function label(): BelongsTo
    {
        return $this->belongsTo(Label::class, 'label_id');
    }

    public function wordRelations(): HasMany
    {
        return $this->hasMany(WordRelation::class, 'lemma_id');
    }

    public function getSlugAttribute(): string
    {
        $slug = Str::slug($this->name);

        return $slug !== '' ? $slug : 'lema';
    }

    /**
     * Scope to search lemmas across multiple fields
     * Searches in: name, name_tagged, and id (if numeric)
     */
    public function scopeSearch($query, $search)
    {
        if (empty($search)) {
            return $query;
        }

        return $query->where(function($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('name_tagged', 'LIKE', "%{$search}%");
            
            // If search is numeric, also search by ID
            if (is_numeric($search)) {
                $q->orWhere('id', '=', (int)$search);
            }
        });
    }
}


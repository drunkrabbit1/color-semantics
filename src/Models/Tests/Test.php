<?php

namespace Drabbit\ColorSemantics\Models\Tests;

use Drabbit\ColorSemantics\Models\Concept;
use Drabbit\ColorSemantics\Models\Results\Result;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Test extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'slug'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function concepts(): BelongsToMany
    {
        return $this->belongsToMany(Concept::class, TestConceptPivot::class,
            'test_id', 'concept_id');
    }

    public function results(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Result::class, 'test_id', 'id');
    }
}

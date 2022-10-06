<?php

namespace Drabbit\ColorSemantics\Models;

use Drabbit\ColorSemantics\Models\Results\ResultConceptPivot;
use Drabbit\ColorSemantics\Traits\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property $title
 */
class Color extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    public function concepts(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Concept::class, ResultConceptPivot::class);
    }
}

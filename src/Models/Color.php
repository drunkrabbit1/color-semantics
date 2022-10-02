<?php

namespace Drabbit\ColorSemantics\Models;

use Drabbit\ColorSemantics\Models\Results\ResultConceptPivot;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
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

    public function concepts()
    {
        return $this->belongsToMany(Concept::class, ResultConceptPivot::class);
    }
}

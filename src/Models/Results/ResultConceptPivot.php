<?php

namespace Drabbit\ColorSemantics\Models\Results;

use Drabbit\ColorSemantics\Models\Color;
use Drabbit\ColorSemantics\Traits\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ResultConceptPivot extends Pivot
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $with = [
        'color'
    ];


    public function color(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Color::class, 'id', 'color_id');
    }
}

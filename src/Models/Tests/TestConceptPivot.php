<?php

namespace Drabbit\ColorSemantics\Models\Tests;

use Drabbit\ColorSemantics\Traits\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TestConceptPivot extends Pivot
{
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
}

<?php

namespace Drabbit\ColorSemantics\Models\Tests;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TestConceptPivot extends Pivot
{
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
}

<?php

namespace Drabbit\ColorSemantics\Models\Results;

use Drabbit\ColorSemantics\Traits\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ResultColorPivot extends Pivot
{
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'index', 'result_id', 'color_id',
    ];
}

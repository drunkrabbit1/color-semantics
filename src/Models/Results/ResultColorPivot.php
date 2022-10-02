<?php

namespace Drabbit\ColorSemantics\Models\Results;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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

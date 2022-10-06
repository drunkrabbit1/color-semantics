<?php

namespace Drabbit\ColorSemantics\Services;

use Illuminate\Support\Collection;

class MathService
{
    public static function standardDeviation (array|Collection $list): float
    {
        if (is_array($list)) $list = Collection::make($list);

        $average = $list->average();

        $variance = $list->sum(fn ($n) => ( ($n - $average) ** 2 ) / $list->count());

        return $variance ** 0.5;
    }
}

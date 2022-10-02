<?php

namespace Drabbit\ColorSemantics\Observers;

use Illuminate\Support\Str;

class ResultColorPivotObserver
{
    use Autoincrement;
    public function creating($model)
    {
        $this->autoincrement($model, 'result_id');
    }
}

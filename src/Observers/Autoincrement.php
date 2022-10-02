<?php

namespace Drabbit\ColorSemantics\Observers;

use Illuminate\Database\Eloquent\Model;

trait Autoincrement
{
    private function autoincrement(Model $model, string $column, string $references = 'index')
    {
        $lastModel = $model::query()
            ->where($column, '=', $model->$column)
            ->orderByDesc($references)->limit(1)->first();
        if ($lastModel) {
            $model->$references = $lastModel->$references + 1;
        } else {
            $model->$references = 1;
        }
    }
}

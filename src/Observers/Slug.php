<?php

namespace Drabbit\ColorSemantics\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait Slug
{
    private function slug(Model $model, string $column = 'slug', $title = null)
    {
        $title = $title ?: $model->name ?: $model->title;
        if (is_null($model->$column)) {
            $slug = Str::limit($title, 250);
            $slug = Str::ascii($slug);

            $model->$column = Str::snake($slug);
        }
    }
}

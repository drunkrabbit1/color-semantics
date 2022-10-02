<?php

namespace Drabbit\ColorSemantics\Observers;


use Illuminate\Support\Str;

class UuidGenerateObserver
{
    public function creating($model)
    {
        if (!$model->id and !Str::isUuid($model->id))
            $model->id = (string) Str::uuid()->toString();
        else $model->id = (string) Str::uuid()->toString();
    }

//    public function updating($model)
//    {
//        if (!$model->id and !Str::isUuid($model->id))
//            $model->id = (string) Str::uuid()->toString();
//        else $model->id = (string) Str::uuid()->toString();
//    }
}

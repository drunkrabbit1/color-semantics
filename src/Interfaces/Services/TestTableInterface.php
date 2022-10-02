<?php

namespace Drabbit\ColorSemantics\Interfaces\Services;

use Drabbit\ColorSemantics\Resources\ColorConceptsJsonResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface TestTableInterface
{
    public function __construct(
        AnonymousResourceCollection|ColorConceptsJsonResource $resource
    );

    /** Выполняет тестирование */
    public function output();


}

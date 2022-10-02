<?php

namespace Drabbit\ColorSemantics\Interfaces\Services;

use Illuminate\Support\Collection;

interface AlgorithmInterface {

    public function __construct(
        Collection $algorithms,
        Collection $concepts,
        bool $isAspiration
    );

	public function estimation();
}

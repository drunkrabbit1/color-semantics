<?php

namespace Drabbit\ColorSemantics\Services\AlgorithmTest;

use Illuminate\Support\Collection;

abstract class BaseAlgorithmService
{
    protected bool $isGroup = false;
    protected bool $isSummation = false;
    protected bool $isMiss = false;
    protected bool $isMultiplied = false;

    protected bool $status = true;

    public int $sum = 0;

    protected Collection $mainAlgorithm;
    protected Collection $conceptsInfo;
    protected Collection $algorithmsInfo;

    public function __construct(
        protected Collection $algorithms,
        protected Collection $concepts,
        protected bool $isAspiration
    )
    {
        $this->mainAlgorithm = $this->algorithms->first();
        $this->conceptsInfo = collect();
        $this->algorithmsInfo = collect();
    }

    abstract public function estimation(): static;

    public function status(): bool
    {
        return $this->status;
    }
}

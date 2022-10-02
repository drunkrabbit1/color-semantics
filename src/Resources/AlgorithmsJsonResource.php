<?php

namespace Drabbit\ColorSemantics\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class AlgorithmsJsonResource extends JsonResource
{
    public function toArray($request): Collection
    {
        return collect([
            'id' => $this->id,
            'description' => $this->description,
            'point' => $this->point,
            'type' => $this->type,
            'note' => collect($this->note()),
        ]);
    }

    private function note(): array|null
    {
        return $this->algorithm_id ? (new self($this->note))->jsonSerialize() : null;
    }
}


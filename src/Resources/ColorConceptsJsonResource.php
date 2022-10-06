<?php

namespace Drabbit\ColorSemantics\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @property string $id
 * @property int $index
 * @property string $title
 * @property int $R
 * @property int $G
 * @property int $B
 */
class ColorConceptsJsonResource extends JsonResource
{

    public function toArray($request): array|Collection|\JsonSerializable|\Illuminate\Contracts\Support\Arrayable
    {
        return Collection::make([
            'id' => $this->id,
            'index' => $this->index,
            'title' => $this->title,
            'R' => $this->R,
            'G' => $this->G,
            'B' => $this->B,
            'concepts' => Collection::make($this->concepts())
        ]);
    }

    private function concepts(): array
    {
        return ConceptsAlgorithmsJsonResource::collection($this->concepts)->jsonSerialize();
    }
}


<?php

namespace Drabbit\ColorSemantics\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class ConceptsAlgorithmsJsonResource extends JsonResource
{

    public function toArray($request): array|Collection|\JsonSerializable|\Illuminate\Contracts\Support\Arrayable
    {
        return Collection::make([
            'id' => $this->id,
            'title' => $this->title,
            'algorithms' => Collection::make($this->algorithms())
        ]);
    }

    private function algorithms(): array
    {
        return AlgorithmsJsonResource::collection($this->algorithms)->jsonSerialize();
    }
}


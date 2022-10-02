<?php

namespace Drabbit\ColorSemantics\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ConceptsAlgorithmsJsonResource extends JsonResource
{

    public function toArray($request)
    {
        return collect([
            'id' => $this->id,
            'title' => $this->title,
            'algorithms' => collect($this->algorithms())
        ]);
    }

    private function algorithms(): array
    {
        return AlgorithmsJsonResource::collection($this->algorithms)->jsonSerialize();
    }
}


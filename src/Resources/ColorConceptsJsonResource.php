<?php

namespace Drabbit\ColorSemantics\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ColorConceptsJsonResource extends JsonResource
{
    public function toArray($request)
    {
        return collect([
            'id' => $this->id,
            'index' => $this->index,
            'title' => $this->title,
            'concepts' => collect($this->concepts())
        ]);
    }

    private function concepts(): array
    {
        return ConceptsAlgorithmsJsonResource::collection($this->concepts)->jsonSerialize();
    }
}


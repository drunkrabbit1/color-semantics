<?php

namespace Drabbit\ColorSemantics\Models\Results;

use Drabbit\ColorSemantics\Models\Concept;
use Drabbit\ColorSemantics\Models\Results\ResultConceptPivot;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property $id
 * @property $title
 */
class Color extends \Drabbit\ColorSemantics\Models\Color
{
    /**
     * @return BelongsToMany
     */
    public function concepts(): BelongsToMany
    {
        return $this->belongsToMany(Concept::class, ResultConceptPivot::class,
            'color_id', 'concept_id');
    }
}

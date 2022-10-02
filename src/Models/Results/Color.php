<?php

namespace Drabbit\ColorSemantics\Models\Results;

use Drabbit\ColorSemantics\Models\Concept;
use Drabbit\ColorSemantics\Models\Results\ResultConceptPivot;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property $title
 */
class Color extends \Drabbit\ColorSemantics\Models\Color
{
    public function concepts()
    {
        return $this->belongsToMany(Concept::class, ResultConceptPivot::class,
            'color_id', 'concept_id')
//            ->where('result_concept_pivot.result_id', $this->result_id)
//        ->whereRaw('result_concept_pivot.result_id = colors.result_id')
            ;
    }
}

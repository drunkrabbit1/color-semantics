<?php

namespace Drabbit\ColorSemantics\Models\Results;

use Drabbit\ColorSemantics\Models\Concept;
use Drabbit\ColorSemantics\Traits\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Result extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'title'
    ];

    /**
     * @return BelongsToMany
     */
    public function concepts(): BelongsToMany
    {
        return $this->belongsToMany(Concept::class, ResultConceptPivot::class,
            'result_id', 'concept_id');
    }

    /**
     * Возвращает цвета в рандомном порядке
     *
     * @return BelongsToMany
     */
    public function colorsForConcepts(): BelongsToMany
    {
        return $this->belongsToMany(Color::class, ResultConceptPivot::class,
            'result_id', 'color_id')->distinct();
    }

    /**
     * @return BelongsToMany
     */
    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class, ResultColorPivot::class,
            'result_id', 'color_id')
            ->orderBy('result_color_pivot.index')
            ->withPivot('result_color_pivot.result_id as result_id')
            ->withPivot('result_color_pivot.index as index')
            ;
    }
}

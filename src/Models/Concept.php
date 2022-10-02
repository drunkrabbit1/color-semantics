<?php

namespace Drabbit\ColorSemantics\Models;

use Drabbit\ColorSemantics\Models\Algorithm\Algorithm;
use Drabbit\ColorSemantics\Models\Algorithm\AlgorithmConcept;
use Drabbit\ColorSemantics\Models\Results\Result;
use Drabbit\ColorSemantics\Models\Results\ResultConceptPivot;
use Drabbit\ColorSemantics\Models\Tests\Test;
use Drabbit\ColorSemantics\Models\Tests\TestConceptPivot;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string $title
 * @property string $id
 *
 * @method static Builder fiducial()
 * @method static Builder defined()
 */
class Concept extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'title',
        'description'
    ];

    protected $casts = [
        'selection_time' => 'datetime:H:i:s.000'
    ];

    public function resultConceptPivot()
    {
        return $this->belongsToMany(Result::class, ResultConceptPivot::class);
    }

    public function tests(): BelongsToMany
    {
        return $this->belongsToMany(Test::class, TestConceptPivot::class,
            'concept_id' , 'test_id');
    }

    public function algorithms(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Algorithm::class, AlgorithmConcept::class,
            'concept_id', 'algorithm_id');
    }

    public function color($result_id = null): BelongsToMany
    {
        $query = $this->belongsToMany(Color::class, ResultConceptPivot::class,
            'concept_id', 'color_id');

        if ($result_id) $query = $query->wherePivot('result_id', $result_id);

        return $query;
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeFiducial($query): Builder
    {
        return $query->has('algorithms');
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeDefined($query): Builder
    {
        return $query->has('algorithms', 0);
    }
}

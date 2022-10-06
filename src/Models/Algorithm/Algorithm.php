<?php

namespace Drabbit\ColorSemantics\Models\Algorithm;

use Drabbit\ColorSemantics\Models\Concept;
use Drabbit\ColorSemantics\Traits\HasUuids;
use Drabbit\ColorSemantics\Enums\AlgorithmType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string $id
 * @property int|null $point
 * @property string $description
 * @property \Drabbit\ColorSymbolism\Enums\AlgorithmType $type
 * @property string $algorithm_id
 *
 * @method Builder whereMain()
 * @method Builder whereNote(string $column, string $option = '=', mixed $value = null, string $boolean = 'and')
 * @method Builder whereParent(string $column, string $option = '=', mixed $value = null, string $boolean = 'and')
 */
class Algorithm extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'point',
        'description',
        'type',
        'algorithm_id',
    ];

    public function scopeWhereMain(Builder $query): Builder
    {
        return $query->has('concepts');
    }

    protected $casts = [
        'type' => AlgorithmType::class
    ];

    /**
     * Список под-алгоритмов
     * @return HasOne
     */
    public function note(): HasOne
    {
        return $this->hasOne(self::class, 'id', 'algorithm_id');
    }

    /**
     * Выводит алгоритм родителя
     * @return HasOne
     */
    public function parent(): HasOne
    {
        return $this->hasOne(self::class, 'algorithm_id', 'id');
    }

    /**
     * Вывод понятий
     * @return BelongsToMany
     */
    public function concepts(): BelongsToMany
    {
        return $this->belongsToMany(Concept::class, AlgorithmConcept::class,
             'algorithm_id', 'concept_id');
    }

    /**
     * Производит where запрос по алгоритму и его под-алгоритмами
     * @param Builder $query
     * @param string $column
     * @param string $option
     * @param mixed|null $value
     * @param string $boolean
     * @return Builder
     */
    public function scopeWhereNote(Builder $query, string $column, string $option = '=', mixed $value = null, string $boolean = 'and'): Builder
    {
        $value = $value ?: $option;
        return $query->has('note', '>=', 1, $boolean, function (Builder $query) use ($column, $option, $value) {
            $query->where($column, $option, $value);
            $query->orWhereHas('note', function (Builder $query) use ($column, $option, $value) {
                $query->where($column, $option, $value);
                $query->orWhereHas('note', function (Builder $query) use ($column, $option, $value) {
                    $query->where($column, $option, $value);
                    $query->orWhereHas('note', function (Builder $query) use ($column, $option, $value) {
                        $query->where($column, $option, $value);
                        $query->orWhereHas('note', function (Builder $query) use ($column, $option, $value) {
                            $query->where($column, $option, $value);
                        });
                    });
                });
            });
        });
    }

    /**
     * Производит where запрос по алгоритму и его алгоритмов-родителей
     *
     * @param Builder $query
     * @param string $column
     * @param string $option
     * @param mixed|null $value
     * @param string $boolean
     * @return Builder
     */
    public function scopeWhereParent(
        Builder $query,
        string $column,
        string $option = '=',
        mixed $value = null,
        string $boolean = 'and'
    ): Builder
    {
        $value = $value ?: $option;

        return $query->has('parent', '>=', 1, $boolean, function (Builder $query) use ($column, $option, $value) {
            $query->where($column, $option, $value);
            $query->orWhereHas('parent', function (Builder $query) use ($column, $option, $value) {
                $query->where($column, $option, $value);
                $query->orWhereHas('parent', function (Builder $query) use ($column, $option, $value) {
                    $query->where($column, $option, $value);
                    $query->orWhereHas('parent', function (Builder $query) use ($column, $option, $value) {
                        $query->where($column, $option, $value);
                        $query->orWhereHas('parent', function (Builder $query) use ($column, $option, $value) {
                            $query->where($column, $option, $value);
                        });
                    });
                });
            });
        });
    }
}

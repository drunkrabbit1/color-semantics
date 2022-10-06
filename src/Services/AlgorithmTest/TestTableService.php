<?php

namespace Drabbit\ColorSemantics\Services\AlgorithmTest;

use Drabbit\ColorSemantics\Models\Algorithm\Algorithm;
use Drabbit\ColorSemantics\Resources\ColorConceptsJsonResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Drabbit\ColorSemantics\Interfaces\Services\TestTableInterface;
use Illuminate\Support\Collection;

class TestTableService implements TestTableInterface
{
    protected Collection $resource;
    protected Collection $result;

    public function __construct(
        ColorConceptsJsonResource|AnonymousResourceCollection $resource,
        protected $maxColumn = 8
    )
    {
        if (ColorConceptsJsonResource::class === $resource->collects) {
            $this->result = Collection::make();
            $this->resource = Collection::make($resource->jsonSerialize());
        }
    }

    private function isAspiration(Collection $color): bool
    {
        $halfMaxColumn = $this->maxColumn / 2;

        return $color->get('index') <= $halfMaxColumn;
    }

    public function output(): static
    {
        $this->resource->map(function (Collection $color) {
            $outputColumn = $this->outputColumn($color);
            $color->offsetSet('point', $outputColumn->sum('sum'));
            $this->result->add(Collection::make([
                'column' => $color->except(['concepts']),
                'rows' => $outputColumn,
                'concepts' => $this->getConceptsForOutputColumn($outputColumn)
            ]));
        })->collapse();

        return $this;
    }

    public function outputColumn(Collection $color): Collection
    {
        $algorithms = $this->getAlgorithmsForAlgorithmService($color);

        $output = $algorithms->map(function (Collection $mainAlgorithm) use($color) {
            $algorithmService = new AlgorithmService(
                $this->getNoteAlgorithmsCollapseForMainAlgorithm($mainAlgorithm),
                $mainAlgorithm->get('concepts'),
                $color->get('concepts'),
                $this->isAspiration($color),
            );

            return $algorithmService->estimation();
        });

        return $output;
    }

    private function getConceptsForOutputColumn($output)
    {
        $outputTemp = clone $output;
        // Собираем все понятия из алгоритмов
        $allConcepts = $outputTemp->map(
            fn (AlgorithmService $algorithmService) => $algorithmService->getConcepts()
        )->collapse();

        // убираем дубли
        $uniqueConcepts = $allConcepts->unique('id');
        // Пересобираем струтуру, добавляя к каждому понятию список алгоритмов и общий бал.
        $uniqueConcepts->each(function (Collection $concept) use ($allConcepts) {
            /** @var Collection $concepts */
            $concepts = $allConcepts->where('id', $concept->get('id'));
            $concept->offsetSet('point', $concepts->sum('point'));
            $withAlgorithms = $concepts
                ->pluck('withAlgorithm')
                ->filter()
                ->map(fn($a) => $a->except(['concepts']))
                ->values();
            $concept->offsetSet('withAlgorithms', $withAlgorithms);
            $concept->offsetUnset('withAlgorithm');
        });

        return $uniqueConcepts;
    }

    public function getColumns(): Collection
    {
        return $this->getResult()->pluck('column');
    }

    public function toTableCollection(): Collection
    {
        $conceptsForColors = $this->getResult()->pluck('concepts', 'column.id');

        $maxCountConceptsForTable = $conceptsForColors
            ->sortByDesc(fn($concepts) => $concepts->count())
            ?->first()
            ->count();

        $collectTable = Collection::make([]);
        for ($i=0; $i < $maxCountConceptsForTable; $i++) {
            $collectTable = $collectTable->merge([
                $conceptsForColors->filter()->map(function ($concepts) {
                    $concept = $concepts->first();

                    if ($concept) $concepts->forget($concepts->keys()->first());

                    return $concept;
                })
            ]);
        }

        $missingColors = $this->getColumns()->pluck('id')->diff($collectTable->first()?->keys());
        // Заполняем цвета которые были упущены
        $collectTable = $collectTable->map(function (Collection $colorForConcepts) use ($missingColors) {
            foreach ($missingColors as $color)
                $colorForConcepts = $colorForConcepts->mergeRecursive([$color => null]);

            return $colorForConcepts;
        });

        $collectTable = $collectTable->map(function ($colorsConcept) {
            return $colorsConcept->sortBy(function ($concepts, $color_id) use ($colorsConcept) {
                return $this->getColumns()->where('id', $color_id)->keys()->first();
            });
        });

        return $collectTable;
    }

    private function getResult(): Collection
    {
        return $this->result;
    }

    /**
     *  Возвращает коллекцию для работы с вычетом балов(AlgorithmTest)
     * @param $color
     * @return Collection
     */
    private function getAlgorithmsForAlgorithmService($color): Collection
    {
        $algorithms = Collection::make();
        /** @var Collection $concepts */
        $concepts = $color->get('concepts');

        // Добавляем все алгоритмы, которые есть у понятий
        $concepts->each(function (Collection $concept) use ($algorithms) {
            $algorithms->add($concept->get('algorithms'));
        });
        // Убираем дубликаты
        $algorithms = $algorithms->collapse()->unique('id');

        // добавляем к алгоритмам, понятия, которые принадлежат к алгоритмам.
        $algorithms->each(function (Collection $algorithm) use($concepts) {
            $conceptsWhereAlgorithm = $concepts
                // Вывести понятия где есть указанный алгоритм
                ->filter(fn ($concept) => $concept->get('algorithms')->where('id', $algorithm->get('id'))->count())
                // Исключить свойство algorithms
                ->map(fn(Collection $concept) => $concept->except(['algorithms']));

            $algorithm->offsetSet('concepts', $conceptsWhereAlgorithm);
        });
        return $algorithms;
    }

    private function setAlgorithmsWithNotes($color)
    {
        $color->get('concepts')->each(function (Collection $concept) {
            $algorithms = $concept->get('algorithms')->map(function (Collection $algorithms) {
                return $this->getNoteAlgorithmsCollapseForMainAlgorithm($algorithms);
            });
            $concept->offsetSet('algorithms', $algorithms);
        });
    }

    public function getNoteAlgorithmsCollapseForMainAlgorithm(Collection $mainAlgorithm): Collection
    {
        $addingAlgorithm = clone $mainAlgorithm;
        $addingAlgorithm->offsetUnset('note');
        $notes = Collection::make()->add($addingAlgorithm);

        while ($mainAlgorithm = $mainAlgorithm->get('note')) {
            if (is_array($mainAlgorithm)) {
                $mainAlgorithm = Collection::make($mainAlgorithm);
            }
            $addingAlgorithm = clone $mainAlgorithm;
            $addingAlgorithm->offsetUnset('note');

            $notes = $notes->add($addingAlgorithm);
        }

        return $notes->filter();
    }
}

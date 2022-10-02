<?php

namespace Drabbit\ColorSemantics\Services;

use Drabbit\ColorSemantics\Resources\ColorConceptsJsonResource;
use Drabbit\ColorSemantics\Services\AlgorithmTest\AlgorithmService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Drabbit\ColorSemantics\Interfaces\Services\TestTableInterface;
use Illuminate\Support\Collection;

class TestTableService implements TestTableInterface
{
    protected Collection $resource;

    public function __construct(
        ColorConceptsJsonResource|AnonymousResourceCollection $resource,
        protected $maxColumn = 8
    )
    {
        if (ColorConceptsJsonResource::class === $resource->collects) {
            $this->resource = Collection::make($resource->jsonSerialize());
        }
    }

    private function isAspiration(Collection $color): bool
    {
        $halfMaxColumn = $this->maxColumn / 2;

        return $color->get('index') <= $halfMaxColumn;
    }

    public function output()
    {
        $output = $this->resource->map(function (Collection $color) use (&$sum){
            return $this->outputColumn($color);
        })->collapse();
//        dd($output->toArray(), 'da');
    }

    public function outputColumn(Collection $color): Collection
    {
        $algorithms = $this->getAlgorithmsForAlgorithmService($color);

        $output = $algorithms->map(function (Collection $mainAlgorithm) use($color) {
            $algorithmService = new AlgorithmService(
                $this->getNoteAlgorithmsCollapseForMainAlgorithm($mainAlgorithm),
                $mainAlgorithm->get('concepts'),
                $this->isAspiration($color)
            );

            return $algorithmService->estimation();
        });

        return $output;
    }

    /**
     *  Возвращает коллекцию для работы с вычетом балов(AlgorithmTest)
     * @param $color
     * @return Collection
     */
    private function getAlgorithmsForAlgorithmService($color): Collection
    {
        $algorithms = collect();
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
        $notes = collect()->add($addingAlgorithm);

        while ($mainAlgorithm = $mainAlgorithm->get('note')) {
            if (is_array($mainAlgorithm)) {
                $mainAlgorithm = collect($mainAlgorithm);
            }
            $addingAlgorithm = clone $mainAlgorithm;
            $addingAlgorithm->offsetUnset('note');

            $notes = $notes->add($addingAlgorithm);
        }

        return $notes->filter();
    }
}

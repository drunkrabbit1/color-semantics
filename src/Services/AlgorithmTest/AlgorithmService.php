<?php

namespace Drabbit\ColorSemantics\Services\AlgorithmTest;

use Drabbit\ColorSemantics\Enums\AlgorithmType;
use Illuminate\Support\Collection;


class AlgorithmService extends BaseAlgorithmService
{
    /**
     * Проводит расчет
     * @return $this
     */
    public function estimation(): static
    {
        $this->algorithms->each(function (Collection $algorithm) {
            if ($this->status) {
                $this->sum += $this->validateAndSum($algorithm);
            }
            else {
                $this->sum = 0;
            }
            $algorithm->offsetSet('status', $this->status);

        });

        $this->addInfo();

        return $this;
    }

    /**
     * Проводит алгоритм по цепочке
     * @param Collection $algorithm
     * @return int
     */
    public function validateAndSum(Collection $algorithm): int
    {
        switch ($algorithm->get('type')) {
            case AlgorithmType::IF_ASPIRATION_ZONE:
                $point = $this->ifAspirationZone($algorithm);
                break;
            case AlgorithmType::IF_AVOIDANCE_ZONE:
                $point = $this->ifAvoidanceZone($algorithm);
                break;
            case AlgorithmType::IN_GROUP:
                $this->isGroup = true;
                $point = $this->inGroup($algorithm);
                break;
            case AlgorithmType::SUMMATION:
                $this->isSummation = true;
                $point = $this->summation($algorithm);
                break;
            case AlgorithmType::MISS:
                $this->isMiss = true;
                $point = $this->miss($algorithm);
                break;
            case AlgorithmType::MULTIPLIED:
                $this->isMultiplied = true;
                $point = $this->multiplied($algorithm);
                break;
            case AlgorithmType::PASSIVE:
            default:
                $point = 0;
                break;
        }

        return $point;
    }

    /**
     * Если Понятие находится в зоне левее
     * @param $algorithm
     * @return int
     */
    private function ifAspirationZone($algorithm): int
    {
        if ($this->isAspiration) {
            return $algorithm->get('point');
        }
        $this->status = false;
        return 0;
    }

    /**
     * Если Понятие находится в зоне правее
     * @param $algorithm
     * @return int
     */
    private function ifAvoidanceZone($algorithm): int
    {
        if (! $this->isAspiration)
            return $algorithm->get('point');

        $this->status = false;
        return 0;
    }

    /**
     * Если понятие есть в списке алгоритма
     * @param $algorithm
     * @return int
     */
    private function inGroup($algorithm): int
    {
        $isInGroupManyOrOne = ($this->concepts->count() >= 1);

        if ($isInGroupManyOrOne) {
            return (int)$algorithm->get('point');
        }
        $this->status = false;
        return 0;
    }

    private function summation($algorithm): int
    {
        // поиск всех алгоритмов, которые имеют ту же концепцию
        $point = $algorithm->get('point');

        return $point;
    }

    /**
     * Если понятие одно
     *
     * @param $algorithm
     * @return int|null
     */
    private function miss($algorithm): ?int
    {
        if ($this->allConcepts->count() == 1)
            return (int) $algorithm->get('point');

        $this->status = false;
        return 0;
    }

    /**
     * Умножает совпадающие понятия на количество баллов
     * @param $algorithm
     * @return float|int
     */
    private function multiplied($algorithm): float|int
    {
        if ($this->status) {
            // сумма всех алгоритмов, которые есть в концепции
//            $concepts = $this->mainAlgorithm->concepts()->whereIn('id', $this->concepts->pluck('id'));
//            $concepts = $this->conceptsWhereAlgorithms($this->mainAlgorithm->get('id'), 'id');
//            $algorithmsSum = AlgorithmTest::query()
//                ->has('concepts')
//                ->whereHas('concepts', function($query) {$query->whereIn('id', $this->concepts->pluck('id'));})
//                ->with('concepts', function($query) {$query->whereIn('id', $this->concepts->pluck('id'));})
//                ->whereNote('id', $algorithm->id)
//                ->whereParent('id', $algorithm->id, boolean: 'or')
//                ->where('type', AlgorithmType::IN_GROUP)
//                ->get();

            // если алгоритм не имеет point, то мы берем количество point алгоритма с типом IN_GROUP
            if ($algorithm->get('point', 0) === 0) {
                $algorithm = $this->algorithms
                    ->where('type', AlgorithmType::IN_GROUP)
                    ->firstWhere('point');

                $point = $algorithm->get('point') * ($this->concepts->count() - 1);
            } else {
                $point = $algorithm->get('point') * $this->concepts->count();
            }

            return (int) $point;
        }

        return 0;
    }

    /**
     * Оставляет логи, проведенного расчета
     * @return void
     */
    private function addInfo(): void
    {
        // Добавляет дополнительные свойства Понятием, для доп. информации
        if ($this->status()) {
            $this->algorithms->each(
                fn($algorithm) => $this->addInfoForConcepts($algorithm)
            );
        } else { // дефолтные данные
            $concepts = $this->concepts->map(function (Collection $concept) {
                $concept->offsetSet('point', 0);
                $concept->offsetSet('withAlgorithm', null);
                $concept->offsetSet('withAlgorithms', null);

                return $concept;
            });
            $this->conceptsInfo->add($concepts);
        }

        // Добавляет общую информацию о проведенных работ
        $this->addAlgorithmInfo();
    }

    /**
     * Изменяет свойства коллекции у Понятий,
     * добавляя им дополнительную информацию,
     * по проделанной работе.
     * @param $algorithm
     * @param $point
     * @return void
     */
    private function addInfoForConcepts($algorithm, $point = null): void
    {
        switch ($algorithm->get('type')) {
            case AlgorithmType::MULTIPLIED:
                $point = $point ?: $algorithm->get('point');
                if ($point === 0) {
                    $algorithm = $this->algorithms
                        ->where('type', AlgorithmType::IN_GROUP)
                        ->firstWhere('point');
                    $point =  $algorithm->get('point');
                }
                $concepts = $this->concepts->map(function (Collection $concept) use ($point, $algorithm) {
                    $concept->offsetSet('point', $concept->get('point')  + $point);

                    $concept->offsetSet('withAlgorithm', $algorithm);
                    $concept->offsetSet('withAlgorithms', $this->algorithms);

                    return $concept;
                });
                $this->conceptsInfo->add($concepts);
                break;
            case AlgorithmType::SUMMATION:
                if (! $this->algorithms->where('type', AlgorithmType::MISS)->count()) {
                    $this->algorithms
                        ->where('type', AlgorithmType::IN_GROUP)
                        ->where('point')->each(function (Collection $algorithm) {
                            $this->concepts
                                ->map(function (Collection $concept) use ($algorithm) {
                                    $sumPoint = $concept->get('point', 0) + $algorithm->get('point');
                                    $concept->offsetSet('point', $sumPoint);

                                    $concept->offsetSet('withAlgorithm', $algorithm);

                                    return $concept;
                                });
                        });
                }
                break;
            case AlgorithmType::MISS:
                if ($point == 0) {
                    $algorithm = $this->algorithms
                        ->where('type', AlgorithmType::IN_GROUP)
                        ->where('point')->first();
                }
                if ($this->conceptsColumn->count() === 1) {
                    $algorithmConcepts = $algorithm->concepts()->get(['id']);
                    $this->concepts
                        ->whereIn('id', $algorithmConcepts->pluck('id'))
                        ->map(function (Concept $concept) use ($algorithm) {
                            $concept->point = $concept->point  + $algorithm->point;

                            $concept->withAlgorithm = $algorithm;
                            $concept->algorithms = $this->algorithms;

                            return $concept;
                        });
                }
                break;
        }
    }

    /**
     * Информация общих сведений по подсчету
     * @return void
     */
    private function addAlgorithmInfo(): void
    {
        $this->algorithmsInfo->add(Collection::make([
            'status' => $this->status,
            'algorithms' => $this->algorithms,
            'concepts' => $this->concepts,
            'points' => $this->sum
        ]));
    }
}

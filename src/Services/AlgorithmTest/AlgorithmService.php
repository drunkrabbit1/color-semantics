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
                $point =  $this->ifAspirationZone($algorithm);
                break;
            case AlgorithmType::IF_AVOIDANCE_ZONE:
                $point =  $this->ifAvoidanceZone($algorithm);
                break;
            case AlgorithmType::IN_GROUP:
                $this->isGroup = true;
                $point = $this->inGroup($algorithm);
                break;
            case AlgorithmType::SUMMATION:
                $this->isSummation = true;
                $point =  $this->summation($algorithm);
                break;
            case AlgorithmType::MISS:
                $this->isMiss = true;
                $point =  $this->miss($algorithm);
                break;
            case AlgorithmType::MULTIPLIED:
                $this->isMultiplied = true;
                $point =  $this->multiplied($algorithm);
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
        if ($this->conceptsColumn->count() == 1)
            return (int) $algorithm->get('point');

        $this->status = false;
        return 0;
    }

    private function multiplied($algorithm): float|int
    {
//        dd($this->algorithms);
        if (true or $this->status) {
            // сумма всех алгоритмов, которые есть в концепции
//            dd($this->mainAlgorithm, 'adas');

//            $concepts = $this->mainAlgorithm->concepts()->whereIn('id', $this->concepts->pluck('id'));
//            $concepts = $this->conceptsWhereAlgorithms($this->mainAlgorithm->get('id'), 'id');
//            dd($this->concepts->toArray(), $this->isAspiration);
//            $algorithmsSum = AlgorithmTest::query()
//                ->has('concepts')
//                ->whereHas('concepts', function($query) {$query->whereIn('id', $this->concepts->pluck('id'));})
//                ->with('concepts', function($query) {$query->whereIn('id', $this->concepts->pluck('id'));})
//                ->whereNote('id', $algorithm->id)
//                ->whereParent('id', $algorithm->id, boolean: 'or')
//                ->where('type', AlgorithmType::IN_GROUP)
//                ->get();

//            if ($algorithm->point == 1) dd($algorithm, $this->status);

            if ($algorithm->get('point') == 0) {
//                dd(1);
                $algorithm = $this->algorithms
                    ->where('type', AlgorithmType::IN_GROUP)
                    ->firstWhere('point');

                $point = $algorithm->get('point') * ($this->concepts->count() - 1);
            } else {
//                dd(2);
//                dd($algorithm->point);
                $point = $algorithm->get('point') * $this->concepts->count();
            }
//            $this->addConceptInfo($algorithm);
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
                fn($algorithm) => $this->addConceptInfo($algorithm)
            );
        } else {
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

    private function addConceptInfo($algorithm, $point = null): void
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
//                                    $concept->offsetSet('algorithms', $this->algorithms);

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

    private function addAlgorithmInfo(): void
    {
        $this->algorithmsInfo->add(collect([
            'status' => $this->status,
            'algorithms' => $this->algorithms,
            'concepts' => $this->concepts,
            'points' => $this->sum
        ]));
    }
}

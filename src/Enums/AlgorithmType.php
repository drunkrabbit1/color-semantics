<?php

namespace Drabbit\ColorSemantics\Enums;

use Illuminate\Support\Collection;
use function collect;

/**
 * Типы алгоритмов
 */
Enum AlgorithmType: string
{
    /** Понятия принадлежащиеся к конкретной группе */
    case IN_GROUP = 'in_group';
    /** Понятия находящиеся в зоне стремления */
    case IF_ASPIRATION_ZONE = 'for_aspiration_zone';
    /** Понятия находящиеся в зоне избегания */
    case IF_AVOIDANCE_ZONE = 'for_avoidance_zone';
    /** ... */
    case MISS = 'missing';
    /** Умножения баллов за понятий в группе(in_group) */
    case MULTIPLIED = 'multiplied';
    /** ... */
    case SUMMATION = 'summation';
    /** ... */
    case PASSIVE = 'passive';

    /**
     * Типы алгоритмов, относящиеся к понятиям
     * @return \Illuminate\Support\Collection
     */
    public static function forConcepts(): \Illuminate\Support\Collection
    {
        return Collection::make(self::cases())->whereIn('name', [
            self::IN_GROUP->name,
            self::MISS->name,
        ]);
    }

    /**
     * Типы под-алгоритмов, относящиеся к основным типам
     * @return \Illuminate\Support\Collection
     */
    public static function forNotes(): \Illuminate\Support\Collection
    {
        return Collection::make(self::cases())->whereIn('name', [
            self::MULTIPLIED->name,
            self::SUMMATION->name,
            self::PASSIVE->name,
            self::IF_ASPIRATION_ZONE->name,
            self::IF_AVOIDANCE_ZONE->name,
        ]);
    }
}

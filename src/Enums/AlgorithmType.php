<?php

namespace Drabbit\ColorSemantics\Enums;

use function collect;

Enum AlgorithmType: string
{
    case IN_GROUP = 'in_group';
    case IF_ASPIRATION_ZONE = 'for_aspiration_zone';
    case IF_AVOIDANCE_ZONE = 'for_avoidance_zone';
    case MISS = 'missing';
    case MULTIPLIED = 'multiplied';
    case SUMMATION = 'summation';
    case PASSIVE = 'passive';

    public static function forConcepts(): \Illuminate\Support\Collection
    {
        return collect(self::cases())->whereIn('name', [
            self::IN_GROUP->name,
            self::MISS->name,
        ]);
    }

    public static function forNotes(): \Illuminate\Support\Collection
    {
        return collect(self::cases())->whereIn('name', [
            self::MULTIPLIED->name,
            self::SUMMATION->name,
            self::PASSIVE->name,
            self::IF_ASPIRATION_ZONE->name,
            self::IF_AVOIDANCE_ZONE->name,
        ]);
    }
}

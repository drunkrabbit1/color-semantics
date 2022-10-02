<?php

namespace Drabbit\ColorSemantics\Enums;

use Illuminate\Support\Collection;
use function collect;

Enum ColorEnum: int
{
    case BLUE = 1;
    case GREEN = 2;
    case RED = 3;
    case YELLOW = 4;
    case VIOLET = 5;
    case BROWN = 6;
    case BLACK = 7;
    case GREY = 0;

    public function rgbFormat(): Collection
    {
        return self::rgb($this);
    }

    public static function rgb(self $colorEnum): Collection
    {
        return match ($colorEnum) {
            self::BLUE      => collect(['R' => 0, 'G' => 0, 'B' => 255,]),
            self::GREEN     => collect(['R' => 0, 'G' => 255, 'B' => 0,]),
            self::RED       => collect(['R' => 255, 'G' => 0, 'B' => 0,]),
            self::YELLOW    => collect(['R' => 255, 'G' => 255, 'B' => 0,]),
            self::VIOLET    => collect(['R' => 221, 'G' => 160, 'B' => 221,]),
            self::BROWN     => collect(['R' => 165, 'G' => 42, 'B' => 42,]),
            self::BLACK     => collect(['R' => 0, 'G' => 0, 'B' => 0,]),
            self::GREY      => collect(['R' => 128, 'G' => 128, 'B' => 128,]),
            default         => collect(),
        };
    }
}

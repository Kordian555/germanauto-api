<?php

namespace App\Filter;

use App\Filter\Interface\FilterInterface;

class Color implements FilterInterface
{
    const COLOR_BLACK = 'black';
    const COLOR_WHITE = 'white';
    const COLOR_GREY = 'grey';
    const COLOR_RED = 'red';
    const COLOR_LIGHT_BLUE = 'light blue';
    const COLOR_BLUE = 'blue';
    const COLOR_DARK_BLUE = 'dark blue';

    public static function all(): array
    {
        $reflection = new \ReflectionClass(self::class);
        return array_values($reflection->getConstants());
    }
    public static function isRequired(): bool
    {
        return true;
    }
}

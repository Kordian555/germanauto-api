<?php

namespace App\Filter;

use App\Filter\Interface\FilterInterface;

class Gear implements FilterInterface
{
    const GEAR_MANUAL = 'manual';
    const GEAR_AUTOMATIC = 'automatic';

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

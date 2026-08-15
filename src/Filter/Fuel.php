<?php

namespace App\Filter;

use App\Filter\Interface\FilterInterface;

class Fuel implements FilterInterface
{
    const FUEL_DIESEL = 'diesel';
    const FUEL_PETROL = 'petrol';

    public static function all(): array
    {
        $reflection = new \ReflectionClass(self::class);
        return array_values($reflection->getConstants());
    }
}

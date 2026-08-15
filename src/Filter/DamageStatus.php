<?php

namespace App\Filter;

use App\Filter\Interface\FilterInterface;

class DamageStatus implements FilterInterface
{
    const DAMAGE_STATUS_UNDAMAGED = 'undamaged';
    const DAMAGE_STATUS_DAMAGED = 'damaged';

    public static function all(): array
    {
        $reflection = new \ReflectionClass(self::class);
        return array_values($reflection->getConstants());
    }
}

<?php

namespace App\Filter;

use App\Filter\Interface\FilterInterface;

class Condition implements FilterInterface
{
    const CONDITION_NEW = 'new';
    const CONDITION_USED = 'used';

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

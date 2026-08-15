<?php

namespace App\Filter;

use App\Filter\Interface\FilterInterface;

class BodyType implements FilterInterface
{
    const BODY_TYPE_SEDAN = 'sedan';
    const BODY_TYPE_COUPE = 'coupe';
    const BODY_TYPE_WAGON = 'wagon';

    public static function all(): array
    {
        $reflection = new \ReflectionClass(self::class);
        return array_values($reflection->getConstants());
    }
}

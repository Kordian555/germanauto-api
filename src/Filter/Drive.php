<?php

namespace App\Filter;

use App\Filter\Interface\FilterInterface;

class Drive implements FilterInterface
{
    const DRIVE_RWD = 'rwd';
    const DRIVE_FWD = 'fwd';
    const DRIVE_AWD = 'awd';
    const DRIVE_4WD = '4wd';

    public static function all(): array
    {
        $reflection = new \ReflectionClass(self::class);
        return array_values($reflection->getConstants());
    }
}

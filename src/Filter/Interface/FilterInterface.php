<?php

namespace App\Filter\Interface;

interface FilterInterface
{
    public static function all(): array;

    public static function isRequired(): bool;
}

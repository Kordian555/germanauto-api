<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ItemNotFoundException extends HttpException
{
    public function __construct(
        string $message = 'Item not found in database'
    )
    {
        parent::__construct(404, $message);
    }
}

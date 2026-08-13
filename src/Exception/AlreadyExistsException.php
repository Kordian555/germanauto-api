<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

class AlreadyExistsException extends HttpException
{
    public function __construct(string $message = 'Item already exists in database')
    {
        parent::__construct(409, $message);
    }
}

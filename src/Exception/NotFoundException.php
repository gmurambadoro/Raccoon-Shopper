<?php

namespace App\Exception;

final class NotFoundException extends \Exception
{
    public function __construct(string $message = "Not Found")
    {
        parent::__construct(message: $message);
    }
}
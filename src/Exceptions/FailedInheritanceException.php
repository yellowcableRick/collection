<?php

namespace YellowCable\Collection\Exceptions;

use Exception;
use Throwable;

class FailedInheritanceException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("Failed inheritance. " . $message, $code, $previous);
    }
}

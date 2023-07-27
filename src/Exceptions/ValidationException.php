<?php

namespace YellowCable\Collection\Exceptions;

use Exception;
use Throwable;

class ValidationException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("Validation issues. " . $message, $code, $previous);
    }
}

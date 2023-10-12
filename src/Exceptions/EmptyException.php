<?php

namespace YellowCable\Collection\Exceptions;

use Exception;
use Throwable;

class EmptyException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("Target or subject is empty. " . $message, $code, $previous);
    }
}

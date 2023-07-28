<?php

namespace YellowCable\Collection\Exceptions;

use Exception;
use Throwable;

class FailedToPersistException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("Failed to persist. " . $message, $code, $previous);
    }
}

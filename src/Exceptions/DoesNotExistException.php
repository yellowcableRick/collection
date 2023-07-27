<?php

namespace YellowCable\Collection\Exceptions;

use Exception;
use Throwable;

class DoesNotExistException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("Whatever you want does not exist. " . $message, $code, $previous);
    }
}

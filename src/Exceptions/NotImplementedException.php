<?php

namespace YellowCable\Collection\Exceptions;

use Exception;
use Throwable;

class NotImplementedException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("Call to method or function failed. Not implemented. " . $message, $code, $previous);
    }
}

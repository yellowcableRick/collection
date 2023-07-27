<?php

namespace YellowCable\Collection\Exceptions;

use Exception;
use Throwable;

class UnequalCountException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("The count was unequal. " . $message, $code, $previous);
    }
}

<?php

namespace YellowCable\Collection\Exceptions;

use Exception;
use Throwable;

class SplitException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("Problem occurred during split:" . $message, $code, $previous);
    }
}

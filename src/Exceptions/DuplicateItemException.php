<?php

namespace YellowCable\Collection\Exceptions;

use Exception;
use Throwable;

/**
 * DuplicateItemException is an exception to be thrown when duplication is found in a collection.
 */
class DuplicateItemException extends Exception
{
    public function __construct(?string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("Duplicates found in collection. " . $message, $code, $previous);
    }
}

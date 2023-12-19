<?php

namespace YellowCable\Collection\Traits\Generic;

use YellowCable\Collection\Exceptions\EmptyException;

trait FirstTrait
{
    /**
     * @throws EmptyException
     */
    public function first(): mixed
    {
        return reset($this->collection) ?: throw new EmptyException();
    }
}

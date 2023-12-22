<?php

namespace YellowCable\Collection\Traits\Locators;

use YellowCable\Collection\Exceptions\EmptyException;

/**
 * @template Item
 */
trait LastTrait
{
    /**
     * @return Item
     * @throws EmptyException
     */
    public function last(): mixed
    {
        return end($this->collection) ?: throw new EmptyException();
    }
}
<?php

namespace YellowCable\Collection\Traits\Locators;

use YellowCable\Collection\Attributes\Item;
use YellowCable\Collection\Exceptions\EmptyException;

/**
 * @template Item
 */
trait FirstTrait
{
    /**
     * @return Item
     * @throws EmptyException
     */
    public function first(): mixed
    {
        return reset($this->collection) ?: throw new EmptyException();
    }
}

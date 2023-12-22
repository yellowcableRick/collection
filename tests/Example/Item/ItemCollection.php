<?php

namespace YellowCable\Collection\Tests\Example\Item;

use YellowCable\Collection\Collection;
use YellowCable\Collection\Tests\Example\Item;

/**
 * @inheritDoc
 * @extends Collection<Item>
 */
class ItemCollection extends Collection
{
    public function getClass(): string
    {
        return Item::class;
    }
}

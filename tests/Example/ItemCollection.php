<?php

namespace YellowCable\Collection\Tests\Example;

use YellowCable\Collection\Collection;

class ItemCollection extends Collection
{
    public function getClass(): string
    {
        return Item::class;
    }
}

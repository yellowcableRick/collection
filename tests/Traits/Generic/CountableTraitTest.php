<?php

namespace YellowCable\Collection\Tests\Traits\Generic;

use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Example\ItemCollection;
use YellowCable\Collection\Tests\Test;

class CountableTraitTest extends Test
{
    public function testCountable(): void
    {
        $collection = new ItemCollection();
        $this->assertEquals(0, $collection->count());
        $collection[] = new Item("1", 1, 1);
        $this->assertEquals(1, $collection->count());
    }
}

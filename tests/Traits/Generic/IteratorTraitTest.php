<?php

namespace YellowCable\Collection\Tests\Traits\Generic;

use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Example\Item\ItemCollection;
use YellowCable\Collection\Tests\Test;

class IteratorTraitTest extends Test
{
    public function testIterator()
    {
        $collection = new ItemCollection("", [
            new Item("item1", 0, 1.00),
            new Item("item2", 0, 2.00),
            new Item("item3", 0, 3.00),
            new Item("item4", 0, 4.00)
        ]);
        foreach ($collection as $item) {
            $this->assertTrue($item instanceof Item);
        }
    }
}

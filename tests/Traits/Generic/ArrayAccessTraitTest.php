<?php

namespace YellowCable\Collection\Tests\Traits\Generic;

use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Example\ItemCollection;
use YellowCable\Collection\Tests\Test;

class ArrayAccessTraitTest extends Test
{
    public function testArrayAccess()
    {
        $item1 = new Item("item1", 0, 1.00);
        $item2 = new Item("item2", 0, 2.00);
        $item3 = new Item("item3", 0, 3.00);
        $item4 = new Item("item4", 0, 4.00);
        $collection = new ItemCollection();

        $collection[1] = $item1;
        $this->assertTrue($collection[1]->getName() === $item1->getName());
        $this->assertTrue($collection->offsetExists(1));

        $collection->offsetSet(2, $item2);
        $this->assertTrue($collection[2]->getName() === $item2->getName());
        $this->assertTrue($collection->count() === 2);

        $key = $collection->getKey(fn (Item $i) => $i->getName() === $item1->getName());
        $collection->offsetSet($key, $item3);
        $this->assertTrue($collection->offsetGet($key)->getName() === $item3->getName());

        $collection->offsetSet(null, $item4);
        $this->assertEquals(3, $collection->getKey(fn (Item $i) => $i->getName() === $item4->getName()));

        $this->assertEquals(null, $collection->offsetGet(0));

        $collection->offsetSet(0, $item1);
        $this->assertTrue($collection->offsetGet(0) === $item1);

        $collection->offsetUnset(1);
        $this->assertFalse($collection->offsetExists(1));
    }
}

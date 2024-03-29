<?php

namespace YellowCable\Collection\Tests\Traits\Generic;

use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Example\Items;
use YellowCable\Collection\Tests\Test;

class ArrayAccessTraitTest extends Test
{
    public function testArrayAccess(): void
    {
        $item1 = new Item("item1", 0, 1.00);
        $item2 = new Item("item2", 0, 2.00);
        $item3 = new Item("item3", 0, 3.00);
        $item4 = new Item("item4", 0, 4.00);
        $collection = new Items();

        $collection[1] = $item1;
        $this->assertTrue($collection[1]?->getName() === $item1->getName());
        $this->assertTrue($collection->offsetExists(1));

        $collection->offsetSet(2, $item2);
        $this->assertTrue($collection[2]?->getName() === $item2->getName());
        $this->assertTrue($collection->count() === 2);

        $collection->offsetSet(1, $item3);
        $this->assertTrue($collection->offsetGet(1)?->getName() === $item3->getName());

        $collection->offsetSet(null, $item4);
        $this->assertEquals($item4, $collection[3]);

        $this->assertEquals(null, $collection->offsetGet(0));

        $collection->offsetSet(0, $item1);
        $this->assertTrue($collection->offsetGet(0) === $item1);

        $collection->offsetUnset(1);
        $this->assertFalse($collection->offsetExists(1));
    }
}

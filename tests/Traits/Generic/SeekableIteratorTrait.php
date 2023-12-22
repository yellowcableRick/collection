<?php

namespace YellowCable\Collection\Tests\Traits\Generic;

use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Example\Item\ItemCollection;
use YellowCable\Collection\Tests\Test;

class SeekableIteratorTrait extends Test
{
    public function testSeekable(): void
    {
        $collection = new ItemCollection("", [
            new Item("item1", 0, 1.00),
            new Item("item2", 0, 2.00),
            new Item("item3", 0, 3.00),
            new Item("item4", 0, 4.00)
        ]);
        $collection->seek(2);
        $this->assertEquals(2, $collection->key());
    }
}

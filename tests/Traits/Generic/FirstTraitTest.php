<?php

namespace YellowCable\Collection\Tests\Traits\Generic;

use YellowCable\Collection\Exceptions\EmptyException;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Example\ItemCollection;
use PHPUnit\Framework\TestCase;

class FirstTraitTest extends TestCase
{
    /**
     * @throws EmptyException
     */
    public function test()
    {
        $item = new Item("1", 1, 1);
        $collection = new ItemCollection("test", [$item]);
        $collection[] = new Item("2", 2, 2);
        $collection[] = new Item("3", 3, 3);
        $collection[] = new Item("4", 4, 4);
        $this->assertEquals($item, $collection->first());
        $collection->offsetUnset(0);
        $this->assertEquals(new Item("2", 2, 2), $collection->first());
    }
}

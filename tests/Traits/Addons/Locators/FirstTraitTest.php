<?php

namespace YellowCable\Collection\Tests\Traits\Addons\Locators;

use PHPUnit\Framework\TestCase;
use YellowCable\Collection\Exceptions\EmptyException;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Example\Items;

class FirstTraitTest extends TestCase
{
    /**
     * @throws EmptyException
     */
    public function test(): void
    {
        $item = new Item("1", 1, 1);
        $collection = new Items("test");
        $collection[] = $item;
        $collection[] = new Item("2", 2, 2);
        $collection[] = new Item("3", 3, 3);
        $collection[] = new Item("4", 4, 4);
        $this->assertEquals($item, $collection->first());
        $collection->offsetUnset(0);
        $this->assertEquals(new Item("2", 2, 2), $collection->first());
    }
}

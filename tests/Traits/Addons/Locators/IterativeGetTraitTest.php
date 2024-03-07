<?php

namespace YellowCable\Collection\Tests\Traits\Addons\Locators;

use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Example\Items;
use YellowCable\Collection\Tests\Test;

class IterativeGetTraitTest extends Test
{
    public function test(): void
    {
        $collection = new Items(
            "test",
            [
                new Item("1", 1, 1),
                new Item("2", 1, 1),
                new Item("3", 1, 1),
                new Item("4", 1, 1),
            ]
        );

        $this->assertInstanceOf(Item::class, $collection->getItem(fn(Item $x) => $x->getName() === "1"));
        $this->assertEquals(
            3,
            $collection->getKey(fn(Item $x) => $x->getName() === "4")
        );
    }
}

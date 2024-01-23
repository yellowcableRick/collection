<?php

namespace YellowCable\Collection\Tests\Traits\Manipulation;

use YellowCable\Collection\Tests\Example\FullTraitedItemCollection;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Test;

class FilterTraitTest extends Test
{
    public function testFilter(): void
    {
        $collection = new FullTraitedItemCollection();
        foreach (
            [
            new Item("1", 1, 1),
            new Item("2", 1, 1),
            new Item("3", 1, 1),
            new Item("4", 1, 1),
            ] as $item
        ) {
            $collection[] = $item;
        }
        $collection->filter(fn(Item $x) => $x->getName() === "1" || $x->getName() === "4");
        $this->assertEquals(2, $collection->count());
    }
}

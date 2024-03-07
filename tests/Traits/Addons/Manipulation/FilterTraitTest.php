<?php

namespace YellowCable\Collection\Tests\Traits\Addons\Manipulation;

use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Example\Items;
use YellowCable\Collection\Tests\Test;
use YellowCable\Collection\Traits\Addons\Manipulation\FilterTrait;

class FilterTraitTest extends Test
{
    public function testFilter(): void
    {
        $collection = new class extends Items {
            use FilterTrait;
        };
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

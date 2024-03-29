<?php

namespace YellowCable\Collection\Tests\Traits\Addons\Manipulation;

use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Example\Items;
use YellowCable\Collection\Tests\Test;

class SplitTraitTest extends Test
{
    public function testSplit(): void
    {
        $collection = new Items();
        foreach (
            [
                new Item("1", 1, 1),
                new Item("2", 2, 1),
                new Item("3", 2, 1),
                new Item("4", 1, 1),
                new Item("5", 2, 1),
                new Item("6", 1, 1),
                new Item("7", 2, 1),
                new Item("8", 1, 1),
                new Item("9", 0, 1),
            ] as $item
        ) {
            $collection[] = $item;
        }
        $splits = $collection->split(fn(Item $x) => (string) $x->counter);
        $this->assertEquals(3, $splits->count());
        $this->assertEquals(4, $splits->getItemByPrimaryKey("2", Items::class)?->count());
    }

    public function testSplitNoResultInCallback(): void
    {
        $collection = new Items();
        foreach (
            [
                new Item("1", 1, null),
                new Item("2", 2, 1),
                new Item("3", 2, 2),
                new Item("4", 1, 1),
                new Item("5", 2, ""),
                new Item("6", 1, 1),
                new Item("7", 2, 0),
                new Item("8", 1, "1"),
                new Item("9", 0, 1),
            ] as $item
        ) {
            $collection[] = $item;
        }
        $splits = $collection->split(fn(Item $x) => $x->anything);
        $this->assertEquals(4, $splits->count());
        $this->assertEquals(1, $splits->getItemByPrimaryKey("", Items::class)?->count());
        $this->assertEquals(5, $splits->getItemByPrimaryKey("1", Items::class)?->count());
        $this->assertEquals(1, $splits->getItemByPrimaryKey("2", Items::class)?->count());
    }
}

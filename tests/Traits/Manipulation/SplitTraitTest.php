<?php

namespace YellowCable\Collection\Tests\Traits\Manipulation;

use YellowCable\Collection\Tests\Example\FullTraitedItem\FullTraitedItemCollection;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Test;

class SplitTraitTest extends Test
{
    public function testSplit(): void
    {
        $collection = new FullTraitedItemCollection("test", [
            new Item("1", 1, 1),
            new Item("2", 2, 1),
            new Item("3", 2, 1),
            new Item("4", 1, 1),
            new Item("5", 2, 1),
            new Item("6", 1, 1),
            new Item("7", 2, 1),
            new Item("8", 1, 1),
            new Item("9", 0, 1),
        ]);
        $splits = $collection->split(fn(Item $x) => (string) $x->counter);
        $this->assertEquals(3, $splits->count());
        /** @var FullTraitedItemCollection $x */
        $x = $splits->getItem(fn (FullTraitedItemCollection $col) => $col->getSplitIdentifier() === "2");
        $this->assertEquals(4, $x->count());
    }

    public function testSplitNoResultInCallback(): void
    {
        $collection = new FullTraitedItemCollection("test", [
            new Item("1", 1, null),
            new Item("2", 2, 1),
            new Item("3", 2, 2),
            new Item("4", 1, 1),
            new Item("5", 2, ""),
            new Item("6", 1, 1),
            new Item("7", 2, 0),
            new Item("8", 1, "1"),
            new Item("9", 0, 1),
        ]);
        $splits = $collection->split(fn(Item $x) => $x->anything);
        $this->assertEquals(4, $splits->count());
        /** @var FullTraitedItemCollection $x */
        $x = $splits->getItem(fn (FullTraitedItemCollection $col) => $col->getSplitIdentifier() === "");
        $this->assertEquals(1, $x->count());

        /** @var FullTraitedItemCollection $x */
        $x = $splits->getItem(fn (FullTraitedItemCollection $col) => $col->getSplitIdentifier() === "1");
        $this->assertEquals(5, $x->count());

        /** @var FullTraitedItemCollection $x */
        $x = $splits->getItem(fn (FullTraitedItemCollection $col) => $col->getSplitIdentifier() == 2);
        $this->assertEquals(1, $x->count());
    }
}

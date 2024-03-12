<?php

namespace YellowCable\Collection\Tests\Traits\Addons\Manipulation;

use YellowCable\Collection\Exceptions\FailedInheritanceException;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Example\Items;
use YellowCable\Collection\Tests\Test;
use YellowCable\Collection\Traits\Addons\Manipulation\SortTrait;

class SortTraitTest extends Test
{
    public function testUsort(): void
    {
        $collection = new Items();
        foreach (
            [
                new Item("10", 1, 1),
                new Item("20", 1, 1),
                new Item("33", 1, 1),
                new Item("46", 1, 1),
                new Item("1", 1, 1),
                new Item("4", 1, 1),
                new Item("16", 1, 1),
                new Item("2", 1, 1),
            ] as $item
        ) {
            $collection[] = $item;
        }

        $collection->usort(fn(Item $x, Item $y) => $x->getName() <=> $y->getName());
        $this->assertEquals("10", $collection[3]?->getName());
        $this->assertEquals("1", $collection[0]?->getName());

        /** @var Item $item */
        foreach ($collection->generator() as $item) {
            $this->assertEquals("1", $item->getName());
            break;
        }
    }

    /**
     * @throws FailedInheritanceException
     */
    public function testUasort(): void
    {
        $collection = new Items();
        foreach (
            [
                new Item("10", 1, 1),
                new Item("20", 1, 1),
                new Item("33", 1, 1),
                new Item("46", 1, 1),
                new Item("1", 1, 1),
                new Item("4", 1, 1),
                new Item("16", 1, 1),
                new Item("2", 1, 1),
            ] as $item
        ) {
            $collection[] = $item;
        }

        $collection->uasort(fn(Item $x, Item $y) => $x->getName() <=> $y->getName());
        $this->assertEquals("46", $collection[3]?->getName());
        $this->assertEquals("10", $collection[0]?->getName());

        /** @var Item $item */
        foreach ($collection->generator() as $item) {
            $this->assertEquals("1", $item->getName());
            break;
        }
    }
}

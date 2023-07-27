<?php

namespace YellowCable\Collection\Tests;

use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Example\ItemCollection;

class CollectionTest extends Test
{
    public function testSetCollection(): void
    {
        $collection = new ItemCollection("test", [
            new Item("1", 1, 1),
            new Item("1", 1, 1),
            new Item("1", 1, 1),
            new Item("1", 1, 1),
        ]);
        $this->assertEquals(4, $collection->count());
    }

    public function testEncapsulation(): void
    {
        $collection = new ItemCollection("test", [
            new Item("1", 1, 1),
            new Item("1", 1, 1),
            new Item("1", 1, 1),
            new Item("1", 1, 1),
        ]);
        $encapsulation = $collection->getEncapsulation();
        $this->assertEquals(4, $collection->count());
        $this->assertEquals(4, $encapsulation->count());
        $this->assertNotNull($collection->offsetGet(0));
        $this->assertNull($encapsulation->offsetGet(0));
    }

    public function testGetters(): void
    {
        $collection = new ItemCollection("test", [
            new Item("1", 1, 1),
            new Item("2", 1, 1),
            new Item("3", 1, 1),
            new Item("4", 1, 1),
        ]);

        $this->assertInstanceOf(Item::class, $collection->getItem(fn(Item $x) => $x->getName() === "1"));
        $this->assertInstanceOf(
            Item::class,
            $collection->offsetGet($collection->getKey(fn(Item $x) => $x->getName() === "1"))
        );
    }

    public function testIdentifier(): void
    {
        $collection = new ItemCollection("", [
            new Item("1", 1, 1),
            new Item("2", 1, 1),
            new Item("3", 1, 1),
            new Item("4", 1, 1),
        ]);

        $this->assertEquals("", $collection->getIdentifier());
        $collection->setIdentifier("test");
        $this->assertEquals("test", $collection->getIdentifier());
    }
}

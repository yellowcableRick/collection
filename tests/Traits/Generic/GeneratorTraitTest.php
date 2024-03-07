<?php

namespace YellowCable\Collection\Tests\Traits\Generic;

use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Example\Items;
use PHPUnit\Framework\TestCase;

class GeneratorTraitTest extends TestCase
{
    public function testGenerator(): void
    {
        $collection = new Items("", [
            new Item("item1", 0, 1.00),
            new Item("item2", 0, 2.00),
            new Item("item3", 0, 3.00),
            new Item("item4", 0, 4.00)
        ]);
        foreach ($collection->generator() as $item) {
            $this->assertTrue($item instanceof Item);
        }
    }

    public function testKeyGenerator(): void
    {
        $collection = new Items("", [
            new Item("item1", 0, 1.00),
            new Item("item2", 0, 2.00),
            new Item("item3", 0, 3.00),
            new Item("item4", 0, 4.00)
        ]);
        $previous = 0;
        foreach ($collection->keyGenerator() as $key) {
            $this->assertEquals($previous++, $key);
        }
    }

    public function testKeyValueGenerator(): void
    {
        $collection = new Items("", [
            new Item("item1", 0, 1.00),
            new Item("item2", 0, 2.00),
            new Item("item3", 0, 3.00),
            new Item("item4", 0, 4.00)
        ]);
        $previous = 0;
        foreach ($collection->keyValueGenerator() as $key => $item) {
            $this->assertEquals($previous++, $key);
            $this->assertTrue($item instanceof Item);
        }
    }
}

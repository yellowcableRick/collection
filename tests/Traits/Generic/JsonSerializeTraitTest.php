<?php

namespace YellowCable\Collection\Tests\Traits\Generic;

use YellowCable\Collection\Collection;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Test;

class JsonSerializeTraitTest extends Test
{
    public function testJsonSerializable(): void
    {
        $collection = new class ("jsonSerialize", [
            new Item("item1", 0, 1.00)
        ]) extends Collection {
            public function getClass(): string
            {
                return Item::class;
            }
        };
        $this->assertEquals(
            '{"collection":[{"counter":0,"anything":1}],"identifier":"jsonSerialize","index":0}',
            json_encode($collection)
        );
    }
}

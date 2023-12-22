<?php

namespace YellowCable\Collection\Tests\Traits\Generic;

use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Example\Item\ItemCollection;
use YellowCable\Collection\Tests\Test;

class JsonSerializeTraitTest extends Test
{
    public function testJsonSerializable(): void
    {
        $collection = new ItemCollection("jsonSerialize", [
            new Item("item1", 0, 1.00)
        ]);
        $this->assertEquals(
            '{"collection":[{"counter":0,"anything":1}],"identifier":"jsonSerialize","index":0}',
            json_encode($collection)
        );
    }
}

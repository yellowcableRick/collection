<?php

namespace YellowCable\Collection\Tests\Traits\Generic;

use YellowCable\Collection\Tests\Example\ItemCollection;
use YellowCable\Collection\Tests\Test;

class MagicMethodsTraitTest extends Test
{
    public function testCall(): void
    {
        $this->expectNotToPerformAssertions();
    }

    public function testToString(): void
    {
        $this->assertEquals("{\"collection\":[],\"index\":0,\"identifier\":\"\"}", (string) (new ItemCollection()));
    }
}

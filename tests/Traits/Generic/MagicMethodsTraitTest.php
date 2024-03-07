<?php

namespace YellowCable\Collection\Tests\Traits\Generic;

use YellowCable\Collection\Tests\Example\Items;
use YellowCable\Collection\Tests\Test;

class MagicMethodsTraitTest extends Test
{
    public function testCall(): void
    {
        $this->expectNotToPerformAssertions();
    }

    public function testToString(): void
    {
        $this->assertEquals(
            '{"collection":[],"identifier":"","primaryKeyValues":null,"lastUpdated":null}',
            (string) (new Items())
        );
    }
}

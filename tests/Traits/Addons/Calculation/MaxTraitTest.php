<?php

namespace YellowCable\Collection\Tests\Traits\Addons\Calculation;

use YellowCable\Collection\Collection;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Example\Items;
use YellowCable\Collection\Tests\Test;
use YellowCable\Collection\Traits\Addons\Calculation\MaxTrait;

class MaxTraitTest extends Test
{
    public function testMax(): void
    {
        $collection = new class () extends Items
        {
            use MaxTrait;
        };

        for ($i = 0; $i <= 100; $i++) {
            $collection[] = new Item("1", $i, $i * 13 * 26);
        }
        $this->assertEquals(100, $collection->getMax("counter"));
        $this->assertEquals(33800, $collection->getMax("anything"));
    }
}

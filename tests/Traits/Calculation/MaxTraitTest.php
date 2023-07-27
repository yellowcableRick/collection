<?php

namespace YellowCable\Collection\Tests\Traits\Calculation;

use YellowCable\Collection\Collection;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Test;
use YellowCable\Collection\Traits\Calculation\MaxTrait;

class MaxTraitTest extends Test
{
    public function testMax(): void
    {
        $collection = new class () extends Collection
        {
            use MaxTrait;

            /**
             * @inheritDoc
             */
            public function getClass(): string
            {
                return Item::class;
            }
        };

        for ($i = 0; $i <= 100; $i++) {
            $collection[] = new Item("1", $i, $i * 13 * 26);
        }
        $this->assertEquals(100, $collection->getMax("counter"));
        $this->assertEquals(33800, $collection->getMax("anything"));
    }
}

<?php

namespace YellowCable\Collection\Tests;

use YellowCable\Collection\AggregationInterface;
use YellowCable\Collection\Exceptions\DoesNotExistException;
use YellowCable\Collection\Exceptions\NotImplementedException;
use YellowCable\Collection\Tests\Example\FullTraitedItemAggregation;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Example\FullTraitedItemCollection;

class SpeedTest extends Test
{
    private int $multiplier = 100000;
    private int $rounds = 10;
    private int $allowedSeconds = 45; // Tested on a MacBook Pro (2019) i9 16GB RAM.

    private function build(int $start, AggregationInterface $aggregation): void
    {
        $collection = (new FullTraitedItemCollection())->setIdentifier("SpeedTest$start");
        $collection->rewind();
        for ($i = $start; $i < $start + (1 * $this->multiplier); $i++) {
            $collection[] = new Item("$i", $i, $i % 19 * 33 / 90);
        }
        $collection->registerCounter("modulo10", fn(Item $x) => !($x->counter % 10));
        $collection->registerCounter("anything<1000", fn(Item $x) => $x->anything < 1000);
        $collection->registerCounter("counter>anything", fn(Item $x) => $x->counter > $x->anything);
        $collection->executeCount();
        $aggregation->addCollection($collection);
    }

    /**
     * @throws DoesNotExistException
     * @throws NotImplementedException
     */
    public function testSpeed(): void
    {
        $time = time();
        $aggregation = new FullTraitedItemAggregation("SpeedTest");
        for ($i = 1; $i <= $this->rounds; $i++) {
            $this->build($i * $this->multiplier, $aggregation);
        }

        $this->assertEquals($this->rounds, $aggregation->count());
        $this->assertEquals(($this->rounds * $this->multiplier), array_sum($aggregation->__call("count")));
        $this->assertEquals(100000, array_sum($aggregation->getCount("modulo10")));//@phpstan-ignore-line
        $this->assertEquals(1000000, array_sum($aggregation->getCount("anything<1000")));//@phpstan-ignore-line
        $this->assertEquals(1000000, array_sum($aggregation->getCount("counter>anything")));//@phpstan-ignore-line
        $this->assertLessThanOrEqual($time + $this->allowedSeconds, time(), "Time diff: " . (time() - $time));
    }
}

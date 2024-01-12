<?php

namespace YellowCable\Collection\Tests;

use DateTime;
use Laravel\SerializableClosure\Exceptions\PhpVersionNotSupportedException;
use YellowCable\Collection\Exceptions\DoesNotExistException;
use YellowCable\Collection\Exceptions\FailedInheritanceException;
use YellowCable\Collection\Exceptions\NotImplementedException;
use YellowCable\Collection\Interfaces\AggregationInterface;
use YellowCable\Collection\Tests\Example\FullTraitedItem\FullTraitedItemAggregation;
use YellowCable\Collection\Tests\Example\FullTraitedItem\FullTraitedItemCollection;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Example\PersistableItem\PersistenceService;

class SpeedTest extends Test
{
    private int $multiplier = 100000;
    private int $rounds = 10;

    /**
     * @throws FailedInheritanceException
     * @throws PhpVersionNotSupportedException
     */
    private function build(int $start, AggregationInterface $aggregation): void
    {
        $collection = new FullTraitedItemCollection();
        $collection->setIdentifier("SpeedTest$start");
        $collection->rewind();
        $collection->setDataProvider(function () use ($start) {
            $set = [];
            for ($i = $start; $i < $start + $this->multiplier; $i++) {
                $set[] = new Item("$i", $i, $i % 19 * 33 / 90);
            }
            return $set;
        });
        $collection->registerCounter("counter>anything", fn(Item $x) => $x->counter > $x->anything);
        $collection->runDataProvider();
        $collection->executeCount();
        $collection->setUpdateProvider(function () use ($start) {
            $set = [];
            for ($i = $start; $i < $start + $this->multiplier; $i += ($this->multiplier / 100)) {
                $set[] = new Item("$i", $i, 3000000);
            }
            return $set;
        });
        $aggregation->addCollection($collection);
    }

    /**
     * @throws DoesNotExistException
     * @throws NotImplementedException
     * @throws PhpVersionNotSupportedException
     * @throws FailedInheritanceException
     * @throws \Exception
     */
    public function testSpeed(): void
    {
        $time = time();
        $aggregation = new FullTraitedItemAggregation();
        $aggregation->setIdentifier("SpeedTest");
        for ($i = 1; $i <= $this->rounds; $i++) {
            $this->build($i * $this->multiplier, $aggregation);
        }
        $aggregation::$persistenceService = new PersistenceService();
        $aggregation->persist();

        $this->assertions($aggregation, $time, 30);

        $secondTime = time();
        $secondAggregation = new FullTraitedItemAggregation();
        $secondAggregation->setIdentifier("SpeedTest");
        $secondAggregation::$persistenceService = new PersistenceService();
        $secondAggregation->hydrate();
        foreach ($secondAggregation as $col) {
            $col->runUpdateProvider();
            $col->registerCounter("anything=3000000", fn (Item $x) => $x->anything === 3000000);
            $col->executeCount(); //@TODO: Should be updateCount();
        }

        $this->assertions($secondAggregation, $secondTime, 1);
    }

    public function assertions(FullTraitedItemAggregation $aggregation, int $time, int $allowedSeconds): void
    {
        $this->assertEquals($this->rounds, $aggregation->count());
        $this->assertEquals(($this->rounds * $this->multiplier), array_sum($aggregation->__call("count")));
        $this->assertEquals(1000000, array_sum($aggregation->getCount("counter>anything")));//@phpstan-ignore-line
        $this->assertLessThanOrEqual($time + $allowedSeconds, time(), "Time diff: " . (time() - $time));
    }


    public function testBigSplit(): void
    {
        $baseTime = microtime(true);
        $collection = new FullTraitedItemCollection("bigSplit");
        for ($i = 1; $i <= 1000000; $i++) {
            $collection[] = new Item(
                "$i",
                rand(1, getrandmax()),
                (int) (new DateTime())->setTimestamp(rand(time() - 31536000, time()))->format("Ymd")
            );
        }
        $collection->split(fn (Item $item) => $item->anything);
        $this->assertLessThanOrEqual(20.00, round(microtime(true) - $baseTime, 2));
    }
}

<?php

namespace YellowCable\Collection\Tests;

use DateTime;
use Laravel\SerializableClosure\Exceptions\PhpVersionNotSupportedException;
use YellowCable\Collection\Exceptions\FailedInheritanceException;
use YellowCable\Collection\Exceptions\NotImplementedException;
use YellowCable\Collection\Interfaces\AggregationInterface;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Tests\Example\Items;
use YellowCable\Collection\Tests\Example\ItemsAggregation;
use YellowCable\Collection\Tests\Example\Persistence;

class SpeedTest extends Test
{
    /**
     * @param int                                                   $start
     * @param AggregationInterface<Item> $aggregation
     * @param int                                                   $amountOfItems
     * @return void
     * @throws PhpVersionNotSupportedException
     */
    private function build(int $start, AggregationInterface $aggregation, int $amountOfItems): void
    {
        $collection = new Items();
        $collection->setIdentifier("SpeedTest$start");
        $collection->rewind();
        $collection->setDataProvider(function () use ($start, $amountOfItems) {
            $set = [];
            for ($i = $start; $i < $start + $amountOfItems; $i++) {
                $set[] = new Item("$i", $i, $i % 19 * 33 / 90);
            }
            return $set;
        });
        $collection->registerCounter("counter>anything", fn(Item $x) => $x->counter > $x->anything);
        $collection->runDataProvider();
        $collection->executeCount();
        $collection->setUpdateProvider(function () use ($start, $amountOfItems) {
            $set = [];
            for ($i = $start; $i < $start + $amountOfItems; $i += 1000) {
                $set[] = new Item("$i", $i, 3000000);
            }
            return $set;
        });
        $aggregation->addCollection($collection, false);
    }

    /**
     * @dataProvider dataProvider
     *
     * @param int   $amountOfItems
     * @param int   $amountOfCollections
     * @param int   $amountPerSecond
     * @param float $totalAllowedTime
     * @return void
     * @throws FailedInheritanceException
     * @throws NotImplementedException
     * @throws PhpVersionNotSupportedException
     */
    public function testSpeed(
        int $amountOfItems,
        int $amountOfCollections,
        int $amountPerSecond,
        float $totalAllowedTime
    ): void {
        $totalTime = microtime(true);
        // Initial setup
        $secForLongActions = ceil($amountOfItems * $amountOfCollections / $amountPerSecond);
        $secForShortActions = ceil($amountOfItems * $amountOfCollections / $amountPerSecond / 10);

        $time = microtime(true);
        $aggregation = new ItemsAggregation();
        $aggregation->setIdentifier("SpeedTest");
        for ($i = 1; $i <= $amountOfCollections; $i++) {
            $this->build($i * $amountOfItems, $aggregation, $amountOfItems);
        }

        $this->assertLessThanOrEqual(
            $secForLongActions,
            max(1.0, round(microtime(true) - $time, 2)),
            "time to create items and collections and aggregate: " . round((microtime(true) - $time), 2)
        );
        $time = microtime(true);

        $aggregation::$persistenceService = new Persistence();
        $aggregation->persist();

        $this->assertLessThanOrEqual(
            $secForLongActions,
            max(1.0, round(microtime(true) - $time, 2)),
            "time to persist: " . round(round((microtime(true) - $time), 2), 2)
        );
        $time = microtime(true);

        $this->assertEquals($amountOfCollections, $aggregation->count());
        $this->assertEquals(
            ($amountOfCollections * $amountOfItems),
            $amount = array_sum($aggregation->__call("count")),
            "amount of items to process: $amount"
        );
        $this->assertEquals(
            ($amountOfCollections * $amountOfItems),
            $amount = array_sum($aggregation->__call("getCount", ["counter>anything"])),
            "amount of items where counter is bigger than anything: $amount"
        );

        $this->assertLessThanOrEqual(
            $secForLongActions,
            max(1.0, round(microtime(true) - $time, 2)),
            "time to handle initial setup: " . round((microtime(true) - $time), 2)
        );

        // Time to retrieve from persistence and handle the aggregation.
        $time = microtime(true);
        $secondAggregation = new ItemsAggregation();
        $secondAggregation->setIdentifier("SpeedTest");
        $secondAggregation::$persistenceService = new Persistence();
        $secondAggregation->hydrate();

        $this->assertLessThanOrEqual(
            $secForShortActions,
            max(1.0, round(microtime(true) - $time, 2)),
            "time to rehydrate from persistence: " . round((microtime(true) - $time), 2)
        );

        $time = microtime(true);
        foreach ($secondAggregation as $col) {
            $col->runUpdateProvider();
        }

        $this->assertLessThanOrEqual(
            $secForLongActions,
            max(1.0, round(microtime(true) - $time, 2)),
            "time to run the update provider: " . round((microtime(true) - $time), 2)
        );

        $time = microtime(true);
        foreach ($secondAggregation as $col) {
            $col->registerCounter("anything=3000000", fn (Item $x) => $x->anything === 3000000);
            $col->updateCount();
        }

        $this->assertLessThanOrEqual(
            $secForShortActions,
            max(1.0, round(microtime(true) - $time, 2)),
            "time to register an extra counter and run an update for counters: " . round((microtime(true) - $time), 2)
        );

        $time = microtime(true);

        $this->assertEquals(
            $amountOfCollections,
            $amount = $aggregation->count(),
            "amount of collections retrieved: $amount"
        );
        $this->assertEquals(
            ($amountOfCollections * $amountOfItems),
            $amount = array_sum($secondAggregation->__call("count")),
            "amount of items retrieved (not really, it's aggregated data): $amount"
        );
        $this->assertEquals(
            ceil(($amountOfCollections * $amountOfItems) / 1000),
            $amount = round(array_sum($secondAggregation->__call("getCount", ["anything=3000000"]))),
            "amount of items which have the value anything set to 3000000 by the update provider: $amount"
        );
        $this->assertLessThanOrEqual(
            $secForShortActions,
            max(1.0, round(microtime(true) - $time, 2)),
            "time to get the new counter: " . round((microtime(true) - $time), 2)
        );

        $this->assertLessThanOrEqual(
            $totalAllowedTime,
            round(microtime(true) - $totalTime, 2),
            "Total time for run: " . (microtime(true) - $totalTime)
        );
    }

    /**
     * @return array<int, array<int|float>>
     */
    public static function dataProvider(): array
    {
        return [
            [1000, 10, 27000, 0.3],
            [1, 1, 27000, 0.01],
            [10, 1, 27000, 0.01],
            [100, 1, 27000, 0.01],
            [1000, 1, 27000, 0.03],
            [10000, 1, 27000, 0.2],
            [100000, 1, 27000, 1.5],
            [1000000, 1, 27000, 22],
            [1000, 10, 27000, 0.3],
            [10000, 10, 27000, 1.5],
            [10000, 100, 27000, 15],
        ];
    }


    public function testBigSplit(): void
    {
        $baseTime = microtime(true);
        $collection = new Items();
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

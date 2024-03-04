<?php

namespace YellowCable\Collection\Traits\Calculation\Counter;

use Exception;
use Laravel\SerializableClosure\SerializableClosure;
use Laravel\SerializableClosure\UnsignedSerializableClosure;
use YellowCable\Collection\Exceptions\DoesNotExistException;
use YellowCable\Collection\Exceptions\NotImplementedException;

/**
 * CounterTrait gives the possibility to build conditional counters for
 * a Collection and by registering first, and executing later it only
 * needs to iterate the Collection once. The conditional is a callable
 * which can contain a single parameter, namely the item in the Collection.
 *
 * @example CounterTrait::registerCount("totalAmount", fn(Item $x) => $x instanceof Item)
 */
trait CounterTrait
{
    abstract public function count(): int;

    /**
     * Contains the registered counters.
     *
     * @var CounterCollection
     */
    private CounterCollection $counters;

    private function getCounters(): object
    {
        return $this->counters ?? $this->counters = new CounterCollection();
    }

    private function createCounter(string $name, UnsignedSerializableClosure $closure): object
    {
        return new Counter($name, $closure);
    }

    /**
     * Register a counter.
     *
     * @param string $name The name which you want to use to get the result later.
     * @param callable $condition The boolean resulting condition which on true ups the counter with 1.
     * @return $this
     */
    public function registerCounter(string $name, callable $condition): static
    {
        $counter = $this->createCounter($name, SerializableClosure::unsigned($condition));
        $this->getCounters()->offsetSet(null, $counter);
        return $this;
    }

    /**
     * Execute all registered counters. Will zero out all counters before running.
     *
     * @return static
     */
    public function executeCount(): static
    {
        foreach ($this->getCounters() as $counter) {
            $counter->result = 0;
        }
        foreach ($this->generator() as $item) {
            foreach ($this->getCounters() as $counter) {
                !$counter->closure->getClosure()($item) ?: $counter->result++;
            }
        }
        return $this;
    }

    /**
     * Updates all registered counters. Will NOT zero out all counters before running.
     * May be interesting to use after aggregation and collecting new items, to append
     * the counters with the new values.
     *
     * @returns static
     */
    public function updateCount(): static
    {
        foreach ($this->generator() as $item) {
            foreach ($this->getCounters() as $counter) {
                !$counter->closure->getClosure()($item) ?: $counter->result++;
            }
        }
        return $this;
    }

    /**
     * Get the result of a counter.
     *
     * @param string $name
     * @return int
     * @throws Exception
     */
    public function getCount(string $name): int
    {
        return $this->getCounters()->isPrimaryKeyPresent($name, Counter::class) ?
            (int) $this->getCounters()->getItem(fn($x) => $x->name === $name)->result :
            throw new DoesNotExistException("Counter with name $name does not exist.");
    }

    /**
     * Get the result of a counter as a percentage against the total of the Collection.
     *
     * @param string $name
     * @return int
     * @throws Exception
     */
    public function getPercentage(string $name): int
    {
        return ($this->getCount($name) && $this->count() > 0) ?
            (int)round((float)$this->getCount($name) / (float)$this->count() * 100.0) :
            0;
    }
}

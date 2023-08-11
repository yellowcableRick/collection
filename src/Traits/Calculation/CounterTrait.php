<?php

namespace YellowCable\Collection\Traits\Calculation;

use Exception;
use Laravel\SerializableClosure\SerializableClosure;
use Laravel\SerializableClosure\UnsignedSerializableClosure;
use YellowCable\Collection\Collection;

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
     * @var Collection
     */
    private Collection $counters;

    private function getCounters(): object
    {
        return $this->counters ??
            $this->counters = new class () extends Collection {
                public function getClass(): string
                {
                    return "";
                }
            };
    }

    private function createCounter(string $name, UnsignedSerializableClosure $closure): object
    {
        return new class ($name, $closure) {
            public function __construct(
                public readonly string $name,
                public readonly UnsignedSerializableClosure $closure,
                public int $result = 0
            ) {
            }
        };
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
     * Execute all registered counters.
     *
     * @return $this
     */
    public function executeCount(): static
    {
        foreach ($this as $item) {
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
        return (int) $this->getCounters()->getItem(fn($x) => $x->name === $name)->result;
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
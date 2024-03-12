<?php

namespace YellowCable\Collection\Traits\Generic;

use Generator;

/**
 * @template Item
 */
trait GeneratorTrait
{
    /**
     * @return Generator<int, Item>
     */
    public function generator(): Generator
    {
        yield from $this->collection;
    }

    /**
     * @return Generator<int>
     */
    public function keyGenerator(): Generator
    {
        foreach (array_keys($this->collection) as $key) {
            yield (int) $key;
        }
    }

    /**
     * @return Generator<int, Item>
     */
    public function keyValueGenerator(): Generator
    {
        foreach ($this->collection as $key => $item) {
            yield $key => $item;
        }
    }
}

<?php

namespace YellowCable\Collection\Traits\Generic;

use Generator;

trait GeneratorTrait
{
    public function generator(): Generator
    {
        yield from $this->collection;
    }

    public function keyGenerator(): Generator
    {
        foreach (array_keys($this->collection) as $key) {
            yield $key;
        }
    }

    public function keyValueGenerator(): Generator
    {
        foreach ($this->collection as $key => $item) {
            yield $key => $item;
        }
    }
}

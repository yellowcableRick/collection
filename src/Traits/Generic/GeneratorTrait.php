<?php

namespace YellowCable\Collection\Traits\Generic;

use Generator;

trait GeneratorTrait
{
    public function generator(): Generator
    {
        yield from $this->collection;
    }
    public function keyValueGenerator(): Generator
    {
        foreach ($this->collection as $key => $item) {
            yield $key => $item;
        }
    }
}

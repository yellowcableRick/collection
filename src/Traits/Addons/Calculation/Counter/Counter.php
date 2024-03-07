<?php

namespace YellowCable\Collection\Traits\Addons\Calculation\Counter;

use Laravel\SerializableClosure\UnsignedSerializableClosure;

class Counter
{
    public function __construct(
        public readonly string $name,
        public readonly UnsignedSerializableClosure $closure,
        public int $result = 0
    ) {
    }
}

<?php

namespace YellowCable\Collection\Traits\Generic;

trait JsonSerializeTrait
{
    /**
     * @inheritDoc
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}

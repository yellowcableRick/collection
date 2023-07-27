<?php

namespace YellowCable\Collection\Tests\Example;

use YellowCable\Collection\Aggregation;

class FullTraitedItemAggregation extends Aggregation
{

    /**
     * @inheritDoc
     */
    public function getClass(): string
    {
        return FullTraitedItemCollection::class;
    }
}
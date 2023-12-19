<?php

namespace YellowCable\Collection\Tests\Example;

use YellowCable\Collection\Interfaces\AggregationInterface;
use YellowCable\Collection\Traits\AggregationTrait;
use YellowCable\Collection\Traits\CollectionTrait;
use YellowCable\Collection\Traits\Datastore\PersistenceTrait;
use YellowCable\Collection\Traits\Locators\FirstIdentifierMatchTrait;

class FullTraitedItemAggregation implements AggregationInterface
{
    use CollectionTrait;
    use AggregationTrait;
    use PersistenceTrait;
    use FirstIdentifierMatchTrait;

    /**
     * @inheritDoc
     */
    public function getClass(): string
    {
        return FullTraitedItemCollection::class;
    }
}

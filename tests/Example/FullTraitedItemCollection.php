<?php

namespace YellowCable\Collection\Tests\Example;

use YellowCable\Collection\Interfaces\CollectionInterface;
use YellowCable\Collection\Traits\Calculation\Counter\CounterTrait;
use YellowCable\Collection\Traits\Calculation\MaxTrait;
use YellowCable\Collection\Traits\CollectionTrait;
use YellowCable\Collection\Traits\Coupler\AggregationTrait;
use YellowCable\Collection\Traits\Datastore\DataProviderTrait;
use YellowCable\Collection\Traits\Datastore\PersistenceTrait;
use YellowCable\Collection\Traits\Datastore\PrimaryKeysTrait;
use YellowCable\Collection\Traits\Generic\CountableTrait;
use YellowCable\Collection\Traits\Validation\HashTrait;

class FullTraitedItemCollection implements CollectionInterface
{
    use CollectionTrait;
    use CountableTrait;
    use CounterTrait;
    use MaxTrait;
    use AggregationTrait;
    use PersistenceTrait;
    use PrimaryKeysTrait;
    use DataProviderTrait;
    use HashTrait;

    public function getClass(): string
    {
        return Item::class;
    }

    public function getPrimaryKey(): string
    {
        return "getName";
    }
}

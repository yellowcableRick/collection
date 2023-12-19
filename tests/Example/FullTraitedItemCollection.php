<?php

namespace YellowCable\Collection\Tests\Example;

use YellowCable\Collection\Collection;
use YellowCable\Collection\Interfaces\CollectionInterface;
use YellowCable\Collection\Traits\Calculation\Counter\CounterTrait;
use YellowCable\Collection\Traits\Calculation\MaxTrait;
use YellowCable\Collection\Traits\CollectionTrait;
use YellowCable\Collection\Traits\Coupler\AggregationTrait;
use YellowCable\Collection\Traits\Datastore\DataProviderTrait;
use YellowCable\Collection\Traits\Datastore\PersistenceTrait;
use YellowCable\Collection\Traits\Datastore\PrimaryKeysTrait;
use YellowCable\Collection\Traits\Generic\CountableTrait;
use YellowCable\Collection\Traits\Generic\FirstTrait;
use YellowCable\Collection\Traits\Generic\GeneratorTrait;
use YellowCable\Collection\Traits\Locators\FirstIdentifierMatchTrait;
use YellowCable\Collection\Traits\Locators\IterativeGetTrait;
use YellowCable\Collection\Traits\Manipulation\FilterTrait;
use YellowCable\Collection\Traits\Manipulation\SortTrait;
use YellowCable\Collection\Traits\Manipulation\SplitTrait;
use YellowCable\Collection\Traits\Validation\HashTrait;

class FullTraitedItemCollection extends Collection implements CollectionInterface
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
    use FilterTrait;
    use SortTrait;
    use SplitTrait;
    use GeneratorTrait;
    use FirstTrait;
    use IterativeGetTrait;

    public function getClass(): string
    {
        return Item::class;
    }

    public function getPrimaryKey(): string
    {
        return "getName";
    }
}

<?php

namespace YellowCable\Collection\Tests\Example\FullTraitedItem;

use YellowCable\Collection\Aggregation;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Traits\Calculation\Counter\CounterTrait;
use YellowCable\Collection\Traits\Calculation\MaxTrait;
use YellowCable\Collection\Traits\Coupler\AggregationTrait;
use YellowCable\Collection\Traits\Datastore\DataProviderTrait;
use YellowCable\Collection\Traits\Datastore\PersistenceTrait;
use YellowCable\Collection\Traits\Generic\CountableTrait;
use YellowCable\Collection\Traits\Generic\GeneratorTrait;
use YellowCable\Collection\Traits\Locators\FirstIdentifierMatchTrait;
use YellowCable\Collection\Traits\Locators\FirstTrait;
use YellowCable\Collection\Traits\Locators\IterativeGetTrait;
use YellowCable\Collection\Traits\Locators\PrimaryKeysTrait;
use YellowCable\Collection\Traits\Manipulation\FilterTrait;
use YellowCable\Collection\Traits\Manipulation\SortTrait;
use YellowCable\Collection\Traits\Manipulation\SplitTrait;
use YellowCable\Collection\Traits\Validation\HashTrait;

/**
 * @extends Aggregation<Item, FullTraitedItemCollection>
 */
class FullTraitedItemAggregation extends Aggregation
{
    use CountableTrait;
    use CounterTrait;
    use MaxTrait;
    use PersistenceTrait;
    /** @use PrimaryKeysTrait<Item> */
    use PrimaryKeysTrait;
    use DataProviderTrait;
    use HashTrait;
    use FilterTrait;
    use SortTrait;
    /** @use SplitTrait<Item> */
    use SplitTrait;
    /** @use FirstTrait<Item> */
    use FirstTrait;
    use IterativeGetTrait;
    use FirstIdentifierMatchTrait;

    /**
     * @inheritDoc
     */
    public function getClass(): string
    {
        return FullTraitedItemCollection::class;
    }

    public function declaredPrimaryKey(): string
    {
        return "getName";
    }
}

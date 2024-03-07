<?php

namespace YellowCable\Collection\Tests\Example\FullTraitedItem;

use YellowCable\Collection\Aggregation;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Traits\Addons\Calculation\Counter\CounterTrait;
use YellowCable\Collection\Traits\Addons\Calculation\MaxTrait;
use YellowCable\Collection\Traits\Addons\Datastore\DataProviderTrait;
use YellowCable\Collection\Traits\Addons\Datastore\PersistenceTrait;
use YellowCable\Collection\Traits\Addons\Locators\FirstIdentifierMatchTrait;
use YellowCable\Collection\Traits\Addons\Locators\FirstTrait;
use YellowCable\Collection\Traits\Addons\Locators\IterativeGetTrait;
use YellowCable\Collection\Traits\Addons\Locators\PrimaryKeysTrait;
use YellowCable\Collection\Traits\Addons\Manipulation\FilterTrait;
use YellowCable\Collection\Traits\Addons\Manipulation\SortTrait;
use YellowCable\Collection\Traits\Addons\Manipulation\SplitTrait;
use YellowCable\Collection\Traits\Addons\Validation\HashTrait;
use YellowCable\Collection\Traits\Generic\CountableTrait;

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

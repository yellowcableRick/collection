<?php

namespace YellowCable\Collection\Tests\Example\FullTraitedItem;

use YellowCable\Collection\Collection;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Traits\Addons\Calculation\Counter\CounterTrait;
use YellowCable\Collection\Traits\Addons\Calculation\MaxTrait;
use YellowCable\Collection\Traits\Addons\Datastore\DataProviderTrait;
use YellowCable\Collection\Traits\Addons\Datastore\PersistenceTrait;
use YellowCable\Collection\Traits\Addons\Locators\FirstTrait;
use YellowCable\Collection\Traits\Addons\Locators\IterativeGetTrait;
use YellowCable\Collection\Traits\Addons\Locators\LastTrait;
use YellowCable\Collection\Traits\Addons\Locators\PrimaryKeysTrait;
use YellowCable\Collection\Traits\Addons\Manipulation\FilterTrait;
use YellowCable\Collection\Traits\Addons\Manipulation\SortTrait;
use YellowCable\Collection\Traits\Addons\Manipulation\SplitTrait;
use YellowCable\Collection\Traits\Addons\Validation\HashTrait;
use YellowCable\Collection\Traits\Coupler\AggregationTrait;
use YellowCable\Collection\Traits\Generic\CountableTrait;

/**
 * @extends Collection<Item>
 */
class FullTraitedItemCollection extends Collection
{
    use CountableTrait;
    use CounterTrait;
    use MaxTrait;
    use AggregationTrait;
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
    /** @use LastTrait<Item> */
    use LastTrait;
    /** @use IterativeGetTrait<Item> */
    use IterativeGetTrait;

    public function getClass(): string
    {
        return Item::class;
    }

    public function declaredPrimaryKey(): string
    {
        return "getName";
    }
}

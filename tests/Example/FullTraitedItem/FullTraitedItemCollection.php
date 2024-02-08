<?php

namespace YellowCable\Collection\Tests\Example\FullTraitedItem;

use YellowCable\Collection\Collection;
use YellowCable\Collection\Tests\Example\Item;
use YellowCable\Collection\Traits\Calculation\Counter\CounterTrait;
use YellowCable\Collection\Traits\Calculation\MaxTrait;
use YellowCable\Collection\Traits\Coupler\AggregationTrait;
use YellowCable\Collection\Traits\Datastore\DataProviderTrait;
use YellowCable\Collection\Traits\Datastore\PersistenceTrait;
use YellowCable\Collection\Traits\Generic\CountableTrait;
use YellowCable\Collection\Traits\Locators\FirstTrait;
use YellowCable\Collection\Traits\Locators\IterativeGetTrait;
use YellowCable\Collection\Traits\Locators\LastTrait;
use YellowCable\Collection\Traits\Locators\PrimaryKeysTrait;
use YellowCable\Collection\Traits\Manipulation\FilterTrait;
use YellowCable\Collection\Traits\Manipulation\SortTrait;
use YellowCable\Collection\Traits\Manipulation\SplitTrait;
use YellowCable\Collection\Traits\Validation\HashTrait;

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
    use PrimaryKeysTrait;
    use DataProviderTrait;
    use HashTrait;
    use FilterTrait;
    use SortTrait;
    use SplitTrait;
    /** @use FirstTrait<Item> */
    use FirstTrait;
    /** @use LastTrait<Item> */
    use LastTrait;
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

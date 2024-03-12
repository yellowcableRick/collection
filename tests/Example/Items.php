<?php

namespace YellowCable\Collection\Tests\Example;

use YellowCable\Collection\Interfaces\CollectionInterface;
use YellowCable\Collection\Interfaces\Locators\FirstIdentifierMatchInterface;
use YellowCable\Collection\Interfaces\Locators\IterativeGetInterface;
use YellowCable\Collection\Traits\Addons\Calculation\Counter\CounterTrait;
use YellowCable\Collection\Traits\Addons\Datastore\DataProviderTrait;
use YellowCable\Collection\Traits\Addons\Datastore\PersistenceTrait;
use YellowCable\Collection\Traits\Addons\Locators\FirstIdentifierMatchTrait;
use YellowCable\Collection\Traits\Addons\Locators\IterativeGetTrait;
use YellowCable\Collection\Traits\Addons\Locators\PrimaryKeysTrait;
use YellowCable\Collection\Traits\Addons\Manipulation\SortTrait;
use YellowCable\Collection\Traits\Addons\Manipulation\SplitTrait;
use YellowCable\Collection\Traits\CollectionTrait;

/**
 * @implements CollectionInterface<Item>
 * @implements FirstIdentifierMatchInterface<Item>
 * @implements IterativeGetInterface<Item>
 */
class Items implements CollectionInterface, FirstIdentifierMatchInterface, IterativeGetInterface
{
    /** @use CollectionTrait<Item> */
    use CollectionTrait;
    use PersistenceTrait;
    /** @use FirstIdentifierMatchTrait<Item> */
    use FirstIdentifierMatchTrait;
    /** @use IterativeGetTrait<Item> */
    use IterativeGetTrait;
    /** @use SplitTrait<Item> */
    use SplitTrait;
    /** @use PrimaryKeysTrait<Item> */
    use PrimaryKeysTrait;
    /** @use DataProviderTrait<Item> */
    use DataProviderTrait;
    /** @use CounterTrait */
    use CounterTrait;
    use SortTrait;

    /**
     * @param string        $identifier
     * @param iterable<Item>|null $source
     */
    public function __construct(string $identifier = "", ?iterable $source = null)
    {
        $this->setIdentifier($identifier);
        !$source ?: $this->setCollection($source);
        self::$persistenceService = new Persistence();
    }

    public function getClass(): string
    {
        return Item::class;
    }

    public function declaredPrimaryKey(): string
    {
        return "name";
    }
}

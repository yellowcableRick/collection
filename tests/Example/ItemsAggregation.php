<?php

namespace YellowCable\Collection\Tests\Example;

use YellowCable\Collection\Aggregation;
use YellowCable\Collection\Interfaces\AggregationInterface;
use YellowCable\Collection\Interfaces\Locators\FirstIdentifierMatchInterface;
use YellowCable\Collection\Traits\Addons\Datastore\PersistenceTrait;
use YellowCable\Collection\Traits\Addons\Locators\FirstIdentifierMatchTrait;
use YellowCable\Collection\Traits\AggregationTrait;

/**
 * @implements AggregationInterface<Items>
 * @implements FirstIdentifierMatchInterface<Items>
 */
class ItemsAggregation extends Aggregation implements AggregationInterface, FirstIdentifierMatchInterface
{
    /** @use AggregationTrait<Items> */
    use AggregationTrait;
    use PersistenceTrait;
    /** @use FirstIdentifierMatchTrait<Items> */
    use FirstIdentifierMatchTrait;

    public function __construct(string $identifier = "")
    {
        self::$persistenceService = new Persistence();
        parent::__construct($identifier);
    }

    public function getClass(): string
    {
        return Items::class;
    }
}

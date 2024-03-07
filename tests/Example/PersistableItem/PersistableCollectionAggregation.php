<?php

namespace YellowCable\Collection\Tests\Example\PersistableItem;

use YellowCable\Collection\Tests\Example\Item\ItemAggregation;
use YellowCable\Collection\Traits\Addons\Datastore\PersistenceTrait;

class PersistableCollectionAggregation extends ItemAggregation
{
    use PersistenceTrait;

    public function __construct(string $identifier = "")
    {
        parent::__construct($identifier);
        self::$persistenceService = new PersistenceService();
    }
}

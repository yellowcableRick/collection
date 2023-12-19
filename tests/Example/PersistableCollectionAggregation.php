<?php

namespace YellowCable\Collection\Tests\Example;

use YellowCable\Collection\Traits\Datastore\PersistenceTrait;

class PersistableCollectionAggregation extends ItemAggregation
{
    use PersistenceTrait;

    public function __construct(string $identifier = "")
    {
        parent::__construct($identifier);
        self::$persistenceService = new PersistenceService();
    }
}

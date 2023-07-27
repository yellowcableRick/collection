<?php

namespace YellowCable\Collection\Tests\Example;

use YellowCable\Collection\Traits\Datastore\PersistenceTrait;

class PersistableItemCollection extends ItemCollection
{
    use PersistenceTrait;

    public function __construct(string $identifier = "", ?array $array = null, ?bool $verify = true)
    {
        parent::__construct($identifier, $array, $verify);
        self::$persistenceService = new PersistenceService();
    }
}

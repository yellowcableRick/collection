<?php

namespace YellowCable\Collection\Tests\Example\PersistableItem;

use YellowCable\Collection\Tests\Example\Item\ItemCollection;
use YellowCable\Collection\Traits\Addons\Datastore\PersistenceTrait;

class PersistableItemCollection extends ItemCollection
{
    use PersistenceTrait;

    /**
     * @inheritDoc
     */
    public function __construct(string $identifier = "", ?iterable $source = null, ?bool $verify = true)
    {
        parent::__construct($identifier, $source, $verify);
        self::$persistenceService = new PersistenceService();
    }
}

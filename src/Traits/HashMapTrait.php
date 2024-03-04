<?php

namespace YellowCable\Collection\Traits;

use YellowCable\Collection\Traits\Locators\PrimaryKeysTrait;

/**
 * @template Item
 */
trait HashMapTrait
{
    /** @use CollectionTrait<Item> */
    use CollectionTrait;
    /** @use PrimaryKeysTrait<Item> */
    use PrimaryKeysTrait;

    /** @var array<string|int, int>  */
    private array $keyMap;

    public function getKeyMap(): array
    {
        if (!isset($this->keyMap)) {
            foreach ($this as $key => $item) {
                $this->keyMap[$this->getPrimaryKeyValue($item)] = $key;
            }
        }
        return $this->keyMap;
    }
}

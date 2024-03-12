<?php

namespace YellowCable\Collection\Traits\Addons\Locators;

use YellowCable\Collection\Exceptions\DoesNotExistException;
use YellowCable\Collection\Exceptions\EmptyException;
use YellowCable\Collection\Exceptions\NotImplementedException;

/**
 * @template Item
 */
trait FirstIdentifierMatchTrait
{
    /** @use FirstTrait<Item> */
    use FirstTrait;

    /**
     * @return Item
     * @throws NotImplementedException
     * @throws EmptyException
     * @throws DoesNotExistException
     */
    public function getFirstIdentifierMatch(string $identifier): mixed
    {
        if (!method_exists($this->first(), "getIdentifier")) {
            throw new NotImplementedException("getIdentifier is not implemented on the elements of this collection");
        }
        foreach ($this as $item) {
            if (method_exists($item, "getIdentifier") && $item->getIdentifier() === $identifier) {
                return $item;
            }
        }
        throw new DoesNotExistException("Couldn't find $identifier");
    }
}

<?php

namespace YellowCable\Collection\Traits\Locators;

use YellowCable\Collection\Exceptions\EmptyException;
use YellowCable\Collection\Exceptions\NotImplementedException;

trait FirstIdentifierMatchTrait
{
    abstract public function first(): mixed;

    /**
     * @throws NotImplementedException
     * @throws EmptyException
     */
    public function getFirstIdentifierMatch(string $identifier): mixed
    {
        if (method_exists($this->first(), "getIdentifier")) {
            foreach ($this as $item) {
                if ($item->getIdentifier() === $identifier) {
                    return $item;
                }
            }

            return null;
        } else {
            throw new NotImplementedException("getIdentifier is not implemented on the elements of this collection");
        }
    }
}

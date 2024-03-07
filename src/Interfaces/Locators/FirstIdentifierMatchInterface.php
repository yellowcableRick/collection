<?php

namespace YellowCable\Collection\Interfaces\Locators;

/**
 * @template Item
 */
interface FirstIdentifierMatchInterface
{
    /**
     * @param string $identifier
     * @return Item|null
     */
    public function getFirstIdentifierMatch(string $identifier): mixed;
}

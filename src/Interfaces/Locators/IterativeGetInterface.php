<?php

namespace YellowCable\Collection\Interfaces\Locators;

/**
 * @template Item
 */
interface IterativeGetInterface
{
    /**
     * Get a key by iterating the collection and returning the first callable equals true hit.
     *
     * @param callable $condition
     * @return int|null
     */
    public function getKey(callable $condition): ?int;

    /**
     * Get an item by iterating the collection and returning the first callable equals true hit.
     *
     * @param callable $condition
     * @return Item
     */
    public function getItem(callable $condition): mixed;
}

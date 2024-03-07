<?php

namespace YellowCable\Collection\Traits\Addons\Locators;

/**
 * @template Item
 */
trait IterativeGetTrait
{
    /**
     * Get the first key from the collection where the item meets the condition.
     *
     * @param callable $condition
     * @return int|null
     */
    public function getKey(callable $condition): ?int
    {
        foreach ($this as $key => $item) {
            if ($condition($item)) {
                return $key;
            }
        }

        return null;
    }

    /**
     * Get the first item from the collection where the item meets the condition.
     *
     * @param callable $condition
     * @return Item|null
     */
    public function getItem(callable $condition): mixed
    {
        foreach ($this as $item) {
            if ($condition($item)) {
                return $item;
            }
        }

        return null;
    }
}

<?php

namespace YellowCable\Collection\Interfaces\Locators;

/**
 * @template Item
 */
interface PrimaryKeysInterface
{
    /**
     * Because we don't know what the primary key property/field will be, the
     * using class should contain a method which tells us whichever it will be.
     *
     * @return string
     */
    public function declaredPrimaryKey(): string;

    /**
     * Iterates all items and creates an array with classnames as keys, and nested arrays with the primary keys.
     *
     * @return array<class-string, array<int, string|int>>
     */
    public function getPrimaryKeyValues(): array;

    /**
     * Method to check if a primary key is present in the key collection.
     *
     * @param int|string  $primaryKey
     * @param string|null $class
     * @return bool
     */
    public function isPrimaryKeyPresent(int|string $primaryKey, ?string $class = ""): bool;

    /**
     * @param int|string  $primaryKey
     * @param string|null $class
     * @return Item|null
     */
    public function getItemByPrimaryKey(int|string $primaryKey, ?string $class = ""): mixed;

    /**
     * Check what the key of the collection is for a certain item. Returns null if the object isn't found.
     *
     * @param object $target
     * @return int|string|null
     */
    public function getCollectionKey(object $target): int|string|null;
}

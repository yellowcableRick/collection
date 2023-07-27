<?php

namespace YellowCable\Collection\Traits\Datastore;

/**
 * PrimaryKeyTrait is used for Iterable classes where the items in the collection
 * have a primary key and are identifiable by it. The trait only enabled either
 * int or string based primary keys.
 */
trait PrimaryKeysTrait
{
    /**
     * The property $primaryKeyValues contains an array with class names as keys,
     * and an array as value containing the primary keys for the collection. The
     * array for the keys must be an array, not hashmap. (use consecutive int as keys)
     *
     * @var array<string, string|int[]> $primaryKeyValues
     */
    public ?array $primaryKeyValues = null;

    /**
     * Because we don't know what the primary key property/field will be, the
     * using class should contain a method which tells us whichever it will be.
     *
     * @return string
     */
    abstract public function getPrimaryKey(): string;

    /**
     * Iterates all items and creates an array with classnames as keys, and nested arrays with the primary keys.
     *
     * @return array<string, string|int[]>
     */
    public function getPrimaryKeyValues(): array
    {
        $primaryKeys = [];

        foreach ($this as $item) {
            if (is_object($item)) {
                if (!isset($primaryKeys[$item::class])) {
                    $primaryKeys[$item::class] = [];
                }

                if ($primaryKey = $this->getPrimaryKey()) {
                    if (isset($item->$primaryKey)) {
                        $primaryKeys[$item::class][] = $item->$primaryKey;
                    } elseif (method_exists($item, $primaryKey)) {
                        $primaryKeys[$item::class][] = $item->$primaryKey();
                    }
                }
            }
        }

        return $this->primaryKeyValues ?? $this->primaryKeyValues = $primaryKeys;
    }

    /**
     * Method to check if a primary key is present in the key collection.
     *
     * @param int|string  $primaryKey
     * @param string|null $class
     * @return bool
     */
    public function isPrimaryKeyPresent(int|string $primaryKey, ?string $class = ""): bool
    {
        $array = $this->primaryKeyValues ?? $this->getPrimaryKeyValues();
        return key_exists($class, $array) && in_array($primaryKey, $array[$class]);
    }
}

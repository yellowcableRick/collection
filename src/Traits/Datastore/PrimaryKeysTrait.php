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
        if (!$this->primaryKeyValues) {
            $primaryKeys = [];

            foreach ($this as $key => $item) {
                if (is_object($item)) {
                    if (!isset($primaryKeys[$item::class])) {
                        $primaryKeys[$item::class] = [];
                    }

                    $primaryKey = $this->getPrimaryKey();
                    if (method_exists($item, $primaryKey)) {
                        $primaryKeys[$item::class][$key] = $item->$primaryKey();
                    } elseif (method_exists($item, "get" . ucfirst($primaryKey))) {
                        $keyGetter = "get" . ucfirst($primaryKey);
                        $primaryKeys[$item::class][$key] = $item->$keyGetter();
                    } elseif (property_exists($item, $primaryKey)) {
                        $primaryKeys[$item::class][$key] = $item->$primaryKey;
                    }
                }
            }

            return $this->primaryKeyValues = $primaryKeys;
        } else {
            return $this->primaryKeyValues;
        }
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
        return key_exists($class, $this->getPrimaryKeyValues()) &&
            in_array($primaryKey, $this->getPrimaryKeyValues()[$class]);
    }

    public function getItemByPrimaryKey(int|string $primaryKey, ?string $class = ""): object|null
    {
        if (key_exists($class, $this->getPrimaryKeyValues())) {
            foreach ($this->getPrimaryKeyValues()[$class] as $key => $primary) {
                if ($primaryKey === $primary) {
                    return $this[$key];
                }
            }
        }
        return null;
    }

    /**
     * Check what the key of the collection is for a certain item. Returns null if the object isn't found.
     *
     * @param object $target
     * @return int|string|null
     */

    public function getCollectionKey(object $target): int|string|null
    {
        $primaryKey = $this->getPrimaryKey();
        if (method_exists($target, $primaryKey)) {
            $targetKey = $target->$primaryKey();
            foreach ($this as $key => $item) {
                if ($targetKey === $item->$primaryKey()) {
                    return $key;
                }
            }
        } elseif (method_exists($target, "get" . ucfirst($primaryKey))) {
            $keyGet = "get" . ucfirst($primaryKey);
            $targetKey = $target->$keyGet();
            foreach ($this as $key => $item) {
                if ($targetKey === $item->$keyGet()) {
                    return $key;
                }
            }
        } elseif (property_exists($target, $primaryKey)) {
            foreach ($this as $key => $item) {
                if ($target->$primaryKey === $item->$primaryKey) {
                    return $key;
                }
            }
        }

        return null;
    }
}

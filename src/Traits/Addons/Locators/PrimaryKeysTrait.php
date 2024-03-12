<?php

namespace YellowCable\Collection\Traits\Addons\Locators;

/**
 * PrimaryKeyTrait is used for Iterable classes where the items in the collection
 * have a primary key and are identifiable by it. The trait only enabled either
 * int or string based primary keys.
 *
 * @template Item
 */
trait PrimaryKeysTrait
{
    /**
     * The property $primaryKeyValues contains an array with class names as keys,
     * and an array as value containing the primary keys for the collection. The
     * array for the keys must be an array, not hashmap. (use consecutive int as keys)
     *
     * @var array<class-string, array<int, string|int>> $primaryKeyValues
     */
    private ?array $primaryKeyValues = null;

    /**
     * Because we don't know what the primary key property/field will be, the
     * using class should contain a method which tells us whichever it will be.
     *
     * @return string
     */
    abstract public function declaredPrimaryKey(): string;

    /**
     * @param Item $item
     * @return int|string|null
     */
    public function getPrimaryKeyValue(mixed $item): int|string|null
    {
        $primaryKey = $this->declaredPrimaryKey();
        if (method_exists($item, $primaryKey)) {
            return $item->$primaryKey();
        } elseif (method_exists($item, "get" . ucfirst($primaryKey))) {
            $keyGetter = "get" . ucfirst($primaryKey);
            return $item->$keyGetter();
        } elseif (property_exists($item, $primaryKey)) {
            return $item->$primaryKey;
        } else {
            return null;
        }
    }

    /**
     * Iterates all items and creates an array with classnames as keys, and nested arrays with the primary keys.
     *
     * @return array<class-string, array<int, string|int>>
     */
    public function getPrimaryKeyValues(): array
    {
        if (!$this->primaryKeyValues || $this->count() !== array_sum(array_map("count", $this->primaryKeyValues))) {
            $this->primaryKeyValues = [];
            /**
             * @var int $key
             * @var Item $item
             */
            foreach ($this as $key => $item) {
                if (is_object($item)) {
                    if (!isset($this->primaryKeyValues[$item::class])) {
                        $this->primaryKeyValues[$item::class] = [];
                    }

                    if (!is_null($pkv = $this->getPrimaryKeyValue($item))) {
                        $this->primaryKeyValues[$item::class][$key] = $pkv;
                    }
                }
            }
        }
        return $this->primaryKeyValues;
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
        return key_exists((string) $class, $this->getPrimaryKeyValues()) &&
            in_array($primaryKey, $this->getPrimaryKeyValues()[$class]);
    }

    /**
     * @param int|string  $primaryKey
     * @param string|null $class
     * @return Item|null
     */
    public function getItemByPrimaryKey(int|string $primaryKey, ?string $class = ""): mixed
    {
        if (key_exists((string) $class, $this->getPrimaryKeyValues())) {
            foreach ($this->getPrimaryKeyValues()[$class] as $key => $primary) {
                if ($primaryKey === $primary) {
                    return $this[$key] ? $this[$key] : null;
                }
            }
        }
        return null;
    }

    /**
     * Check what the key of the collection is for a certain item. Returns null if the object isn't found.
     *
     * @param Item $target
     * @return int|null
     */
    public function getCollectionKey(mixed $target): int|null
    {
        $pkv = $this->getPrimaryKeyValue($target);
        if ($pkvs = $this->getPrimaryKeyValues()) {
            foreach ($pkvs[$target::class] as $key => $value) {
                if ($value === $pkv) {
                    return $key;
                }
            }
        } else {
            foreach ($this as $key => $item) {
                if ($pkv === $this->getPrimaryKeyValue($item)) {
                    return $key;
                }
            }
        }
        return null;
    }
}

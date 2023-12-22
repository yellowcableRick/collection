<?php

namespace YellowCable\Collection\Traits\Generic;

use YellowCable\Collection\Exceptions\DoesNotExistException;
use YellowCable\Collection\Exceptions\NotImplementedException;

trait MagicMethodsTrait
{
    /**
     * Magic method __call is implemented to pass any method not known
     * by Collection to call upon all collected items, and
     * return all outputs from the items in an array.
     *
     * NOTICE: All basic functionality of the items isn't callable
     * through this magic method, as where this Collection model is build upon
     * the same architecture. If you want to use any method from the Collection
     * structure, iterate this Aggregation and then call the methods directly on
     * the item(s).
     *
     * @param string $name
     * @param array $arguments
     * @return array
     * @throws NotImplementedException
     */
    public function __call(string $name, array $arguments = []): array
    {
        $output = [];
        foreach ($this as $item) {
            $identifier = method_exists($item, "getIdentifier") ? $item->getIdentifier() : null;
            !method_exists($item, $name) ?:
                $output[$identifier] = call_user_func_array([$item, $name], $arguments);
        }

        return $output;
    }

    /**
     * @throws DoesNotExistException
     */
    public function __get(string $name)
    {
        throw new DoesNotExistException("Property \"$name\" does not exist on this collection.");
    }

    /**
     * @throws DoesNotExistException
     */
    public function __set(string $name, $value): void
    {
        throw new DoesNotExistException("Property does not exist on this collection.");
    }

    /**
     * When cast to string, this collection will return a jsonSerialize or serialize
     * representation of the collection. If jsonSerialize is implemented, it will
     * get precedent.
     *
     * @return string
     */
    public function __toString(): string
    {
        if (method_exists($this, "jsonSerialize")) {
            return json_encode($this);
        } else {
            return serialize($this);
        }
    }
}

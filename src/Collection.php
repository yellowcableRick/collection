<?php

namespace YellowCable\Collection;

use YellowCable\Collection\Interfaces\CollectionInterface;
use YellowCable\Collection\Traits\CollectionTrait;

/**
 * Collection gives a flexible object in which you can create collections
 * of items, in the form of anything you would like to collect. Assuming any
 * developer knows the upside of using ValueObjects, there is no need to create
 * a collection of primitives.
 *
 * Any Collection based of this abstract can use additional Traits from the
 * "Collection\Traits" namespace. These traits can be "used" in any subclass.
 *
 * Do notice, php's native array methods DO NOT WORK on this object. Examples are
 * array_map, array_keys, array_values etc. Iterative methods like foreach do work.
 *
 * @template Item
 * @implements CollectionInterface<Item>
 */
abstract class Collection implements CollectionInterface
{
    /** @use CollectionTrait<Item> */
    use CollectionTrait;

    /**
     * Collection Constructor; Initializes class properties
     * and provides a way to directly import a collection from array.
     *
     * @param string                $identifier
     * @param iterable<Item>|null   $source Iterator or array of objects which should fill the collection.
     * @param bool|null             $verify boolean; verify if the passed array contains only items of the given class.
     */
    public function __construct(string $identifier = "", ?iterable $source = null, ?bool $verify = true)
    {
        $this->setIdentifier($identifier);
        $this->setCollection($source ?? [], $verify);
        $this->rewind();
    }
}

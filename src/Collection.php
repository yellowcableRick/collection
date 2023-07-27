<?php

namespace YellowCable\Collection;

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
 */
abstract class Collection implements CollectionInterface
{
    use CollectionTrait;

    /**
     * Collection Constructor; Initializes class properties
     * and provides a way to directly import a collection from array.
     *
     * @param array<int, mixed>|null $array Array of objects which should fill the collection.
     * @param bool|null  $verify Boolean; verify if the passed array contains only items of the given class.
     */
    public function __construct(string $identifier = "", ?array $array = null, ?bool $verify = true)
    {
        $this->setIdentifier($identifier);
        $this->setCollection($array ?? [], $verify);
        $this->rewind();
    }
}

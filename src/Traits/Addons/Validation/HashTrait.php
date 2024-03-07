<?php

namespace YellowCable\Collection\Traits\Addons\Validation;

/**
 * HashTrait enables the using class to generate a xxh3 hash of itself,
 * and verify if changes where made to itself. You can also use this
 * to generate a hash, and export is elsewhere. Setting the optional
 * parameter on the verify method grants the ability to use an exported
 * hash to verify against the current state.
 */
trait HashTrait
{
    /** @var string $hash Contains the hash of this object. */
    private string $hash = "";

    /**
     * Hash this object using the print_r string presentation and the xxh3 algorithm.
     *
     * @return string
     */
    public function getHash(): string
    {
        $this->hash = "";
        return $this->hash = hash("xxh3", print_r($this, true));
    }

    /**
     * Verify the previously set hash with a newly generated hash.
     * The optional parameter grants the ability to pass a previously
     * generated hash to be compared to the newly generated hash of this
     * object.
     *
     * @param string|null $hash
     * @return bool
     */
    public function verifyHash(?string $hash = null): bool
    {
        return ($hash) ? $hash === $this->getHash() : $this->hash === $this->getHash();
    }
}

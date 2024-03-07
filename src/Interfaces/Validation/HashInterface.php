<?php

namespace YellowCable\Collection\Interfaces\Validation;

interface HashInterface
{
    /**
     * Hash this object using the print_r string presentation and the xxh3 algorithm.
     *
     * @return string
     */
    public function getHash(): string;

    /**
     * Verify the previously set hash with a newly generated hash.
     * The optional parameter grants the ability to pass a previously
     * generated hash to be compared to the newly generated hash of this
     * object.
     *
     * @param string|null $hash
     * @return bool
     */
    public function verifyHash(?string $hash = null): bool;
}

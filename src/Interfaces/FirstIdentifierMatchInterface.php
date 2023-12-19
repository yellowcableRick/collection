<?php

namespace YellowCable\Collection\Interfaces;

interface FirstIdentifierMatchInterface
{
    public function getFirstIdentifierMatch(string $identifier): mixed;
}

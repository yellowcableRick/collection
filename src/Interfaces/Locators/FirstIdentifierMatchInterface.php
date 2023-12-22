<?php

namespace YellowCable\Collection\Interfaces\Locators;

interface FirstIdentifierMatchInterface
{
    public function getFirstIdentifierMatch(string $identifier): mixed;
}

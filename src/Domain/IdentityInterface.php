<?php

namespace App\Domain;

interface IdentityInterface
{
    /**
     * @return string
     */
    public function getValue(): string;
}
<?php

declare(strict_types=1);

namespace App\Domain;

class AlertIdentity implements IdentityInterface
{
    /** @var string */
    private $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
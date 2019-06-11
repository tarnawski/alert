<?php

declare(strict_types=1);

namespace App\Application\Command;

class ConfirmAlertCommand
{
    /** @var string */
    private $identity;

    /**
     * NotifyAlertCommand constructor.
     * @param string $identity
     */
    public function __construct(string $identity)
    {
        $this->identity = $identity;
    }

    /**
     * @return string
     */
    public function getIdentity(): string
    {
        return $this->identity;
    }
}
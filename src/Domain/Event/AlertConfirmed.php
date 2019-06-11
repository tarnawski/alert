<?php

namespace App\Domain\Event;

use App\Domain\DomainEventInterface;
use App\Domain\AlertIdentity;

class AlertConfirmed implements DomainEventInterface
{
    /** @var AlertIdentity */
    private $identity;

    /**
     * @param AlertIdentity $identity
     */
    public function __construct(AlertIdentity $identity)
    {
        $this->identity = $identity;
    }

    /**
     * @return string
     */
    public function getAggregateId(): string
    {
        return $this->identity->getValue();
    }

    /**
     * @return AlertIdentity
     */
    public function getIdentity(): AlertIdentity
    {
        return $this->identity;
    }
}

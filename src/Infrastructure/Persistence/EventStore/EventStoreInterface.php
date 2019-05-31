<?php

namespace App\Infrastructure\Persistence\EventStore;

use App\Domain\DomainEventInterface;
use App\Domain\IdentityInterface;

interface EventStoreInterface
{
    /**
     * @param DomainEventInterface $event
     */
    public function commit(DomainEventInterface $event): void;

    /**
     * @param IdentityInterface $identity
     * @return array
     */
    public function getAggregateHistoryForIdentity(IdentityInterface $identity): array;
}
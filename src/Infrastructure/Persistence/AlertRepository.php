<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Alert;
use App\Domain\AlertIdentity;
use App\Domain\DomainEventInterface;
use App\Domain\Repository\AlertRepositoryInterface;
use App\Infrastructure\Persistence\EventStore\EventStoreInterface;

class AlertRepository implements AlertRepositoryInterface
{
    /** @var EventStoreInterface */
    private $eventStore;

    /**
     * @param EventStoreInterface $eventStore
     */
    public function __construct(EventStoreInterface $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    /**
     * @param AlertIdentity $identity
     * @return Alert
     * @throws \ReflectionException
     */
    public function get(AlertIdentity $identity): Alert
    {
        $events = $this->eventStore->getAggregateHistoryForIdentity($identity);

        return Alert::reconstituteFromHistory($events);
    }

    /**
     * @param Alert $alert
     */
    public function persist(Alert $alert): void
    {
        /** @var DomainEventInterface $event */
        foreach ($alert->getEvents() as $event) {
            $this->eventStore->commit($event);
        }
    }
}
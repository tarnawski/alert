<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Alert;
use App\Domain\AlertIdentity;
use App\Domain\DomainEventInterface;
use App\Domain\Repository\AlertRepositoryInterface;
use App\Infrastructure\Persistence\EventStore\EventStoreInterface;
use App\Infrastructure\Projection\PDOAlertProjection;
use ReflectionException;

class AlertRepository implements AlertRepositoryInterface
{
    /** @var EventStoreInterface */
    private $eventStore;

    /** @var PDOAlertProjection */
    private $alertProjection;

    /**
     * @param EventStoreInterface $eventStore
     * @param PDOAlertProjection $alertProjection
     */
    public function __construct(EventStoreInterface $eventStore, PDOAlertProjection $alertProjection)
    {
        $this->eventStore = $eventStore;
        $this->alertProjection = $alertProjection;
    }

    /**
     * @param AlertIdentity $identity
     * @return Alert
     * @throws ReflectionException
     */
    public function get(AlertIdentity $identity): Alert
    {
        $events = $this->eventStore->getAggregateHistoryForIdentity($identity);

        return Alert::reconstituteFromHistory($events);
    }

    /**
     * @param Alert $alert
     * @throws ReflectionException
     */
    public function persist(Alert $alert): void
    {
        /** @var DomainEventInterface $event */
        foreach ($alert->getEvents() as $event) {
            $this->eventStore->commit($event);
            $this->alertProjection->project($event);
        }

        $alert->clearEvents();
    }
}
<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Event\AlertCreated;
use App\Domain\Alert\Position;
use App\Domain\Alert\Type;
use ReflectionClass;
use ReflectionException;

class Alert
{
    /** @var AlertIdentity */
    private $identity;

    /** @var Type */
    private $type;

    /** @var Position */
    private $position;

    /** @var DomainEventInterface[] */
    protected $events = [];

    /**
     * @param AlertIdentity $identity
     * @param Type $type
     * @param Position $position
     * @return Alert
     * @throws ReflectionException
     */
    public static function createWithData(AlertIdentity $identity, Type $type, Position $position): self
    {
        $self = new self();
        $self->recordThat(
            new AlertCreated($identity, $type->getName(), $position->getLatitude(), $position->getLongitude())
        );

        return $self;
    }

    /**
     * @return AlertIdentity
     */
    public function getIdentity(): AlertIdentity
    {
        return $this->identity;
    }

    /**
     * @param AlertIdentity $identity
     */
    public function setIdentity(AlertIdentity $identity): void
    {
        $this->identity = $identity;
    }

    /**
     * @return Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * @param Type $type
     */
    public function setType(Type $type): void
    {
        $this->type = $type;
    }

    /**
     * @return Position
     */
    public function getPosition(): Position
    {
        return $this->position;
    }

    /**
     * @param Position $position
     */
    public function setPosition(Position $position): void
    {
        $this->position = $position;
    }

    /**
     * @return DomainEventInterface[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    /**
     * @param DomainEvent[] $events
     * @return Alert
     * @throws ReflectionException
     */
    public static function reconstituteFromHistory(array $events): Alert
    {
        $alert = new Alert();
        foreach ($events as $event) {
            $alert->apply($event);
        }

        return $alert;
    }

    /**
     * @param DomainEventInterface $event
     * @throws ReflectionException
     */
    public function recordThat(DomainEventInterface $event): void
    {
        $this->events[] = $event;
        $this->apply($event);
    }

    /**
     * @param DomainEventInterface $event
     * @throws ReflectionException
     */
    public function apply(DomainEventInterface $event)
    {
        $method = sprintf('apply%s', (new ReflectionClass($event))->getShortName());
        $this->$method($event);
    }

    /**
     * @param AlertCreated $event
     * @throws Exception\PositionException
     * @throws Exception\TypeException
     */
    public function applyAlertCreated(AlertCreated $event): void
    {
        $this->identity = $event->getIdentity();
        $this->type = new Type($event->getType());
        $this->position = new Position($event->getLatitude(), $event->getLongitude());
    }
}

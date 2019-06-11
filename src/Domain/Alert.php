<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Event\AlertConfirmed;
use App\Domain\Event\AlertCreated;
use App\Domain\Alert\Position;
use App\Domain\Alert\Type;
use ReflectionClass;
use ReflectionException;

class Alert
{
    /** @var string */
    const STATUS_UNCONFIRMED = 'unconfirmed';

    /** @var string */
    const STATUS_CONFIRMED = 'confirmed';

    /** @var AlertIdentity */
    private $identity;

    /** @var Type */
    private $type;

    /** @var string */
    private $status;

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
     * @return Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    public function confirm(): void
    {
        $this->recordThat(
          new AlertConfirmed($this->getIdentity())
        );
    }

    /**
     * @return Position
     */
    public function getPosition(): Position
    {
        return $this->position;
    }

    /**
     * @return DomainEventInterface[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    public function clearEvents(): void
    {
        $this->events = [];
    }

    /**
     * @param DomainEventInterface[] $events
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
        $this->status = self::STATUS_UNCONFIRMED;
        $this->position = new Position($event->getLatitude(), $event->getLongitude());
    }

    /**
     * @param AlertConfirmed $event
     */
    public function applyAlertConfirmed(AlertConfirmed $event): void
    {
        $this->status = self::STATUS_CONFIRMED;
    }
}

<?php

namespace App\Domain\Event;

use App\Domain\DomainEventInterface;
use App\Domain\AlertIdentity;

class AlertCreated implements DomainEventInterface
{
    /** @var AlertIdentity */
    private $identity;

    /** @var string */
    private $type;

    /** @var float */
    private $latitude;

    /** @var float */
    private $longitude;

    /**
     * @param AlertIdentity $identity
     * @param string $type
     * @param float $latitude
     * @param float $longitude
     */
    public function __construct(AlertIdentity $identity, string $type, float $latitude, float $longitude)
    {
        $this->identity = $identity;
        $this->type = $type;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
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

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @return string
     */
    public function serialize(): string
    {
        return json_encode([
            'type' => $this->getType(),
            'latitude' => $this->getLatitude(),
            'longitude' => $this->getLongitude()
        ]);
    }

    public function unserialize($serialized)
    {
        // TODO: Implement unserialize() method.
    }
}
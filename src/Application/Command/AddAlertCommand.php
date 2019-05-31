<?php

declare(strict_types=1);

namespace App\Application\Command;

class AddAlertCommand
{
    /** @var string */
    private $identity;

    /** @var string */
    private $type;

    /** @var float */
    private $latitude;

    /** @var float */
    private $longitude;

    /**
     * NotifyAlertCommand constructor.
     * @param string $identity
     * @param string $type
     * @param float $latitude
     * @param float $longitude
     */
    public function __construct(string $identity, string $type, float $latitude, float $longitude)
    {
        $this->identity = $identity;
        $this->type = $type;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * @return string
     */
    public function getIdentity(): string
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
}
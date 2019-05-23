<?php

declare(strict_types=1);

namespace App\Application\Command;

class NotifyAlertCommand
{
    /** @var string */
    private $type;

    /** @var float */
    private $latitude;

    /** @var float */
    private $longitude;

    /**
     * @param string $type
     * @param float $latitude
     * @param float $longitude
     */
    public function __construct(string $type, float $latitude, float $longitude)
    {
        $this->type = $type;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
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
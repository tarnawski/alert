<?php

declare(strict_types=1);

namespace App\Application\Query;

class AlertQuery
{
    /** @var string */
    private $latitude;

    /** @var string */
    private $longitude;

    /**
     * @param string $latitude
     * @param string $longitude
     */
    public function __construct(string $latitude, string $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * @return string
     */
    public function getLatitude(): string
    {
        return $this->latitude;
    }

    /**
     * @return string
     */
    public function getLongitude(): string
    {
        return $this->longitude;
    }
}
<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Exception\PositionException;

class Position
{
    /** @var float */
    private $latitude;

    /** @var float */
    private $longitude;

    /**
     * @param float $latitude
     * @param float $longitude
     * @throws PositionException
     */
    public function __construct(float $latitude, float $longitude)
    {
        if ($latitude < -90 || $latitude > 90) {
            throw new PositionException('Latitude in not correct');
        }

        if ($longitude < -180 || $longitude > 180) {
            throw new PositionException('Longitude in not correct');
        }

        $this->latitude = $latitude;
        $this->longitude = $longitude;
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

<?php

declare(strict_types=1);

namespace App\Domain\Model;

class SearchCriteria
{
    /** @var string */
    private $latitude;

    /** @var string */
    private $longitude;

    /** @var string */
    private $type;

    /**
     * SearchCriteria constructor.
     * @param string $latitude
     * @param string $longitude
     * @param string|null $type
     */
    public function __construct(string $latitude, string $longitude, ?string $type = null)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->type = $type;
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

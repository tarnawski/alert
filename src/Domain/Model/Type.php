<?php

declare(strict_types=1);

namespace App\Domain\Model;

class Type
{
    const SECTION_SPEED_CAMERA = 'section_speed_camera';
    const SPEED_CAMERA = 'speed_camera';
    const DANGEROUS_PLACE = 'dangerous_place';
    const DANGEROUS_RAILWAY_CROSSING = 'dangerous_railway_crossing';

    /** @var string */
    private $name;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}

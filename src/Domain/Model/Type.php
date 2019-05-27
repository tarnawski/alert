<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Exception\TypeException;

class Type
{
    const SECTION_SPEED_CAMERA = 'section_speed_camera';
    const SPEED_CAMERA = 'speed_camera';
    const DANGEROUS_PLACE = 'dangerous_place';
    const DANGEROUS_RAILWAY_CROSSING = 'dangerous_railway_crossing';

    const AVAILABLE_TYPES = [
        self::SECTION_SPEED_CAMERA,
        self::SPEED_CAMERA,
        self::DANGEROUS_PLACE,
        self::DANGEROUS_RAILWAY_CROSSING
    ];

    /** @var string */
    private $name;

    /**
     * Type constructor.
     * @param string $name
     * @throws TypeException
     */
    public function __construct(string $name)
    {
        if (!in_array($name, self::AVAILABLE_TYPES)) {
            throw new TypeException('This type is not allowed!');
        }

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

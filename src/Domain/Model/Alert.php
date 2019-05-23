<?php

declare(strict_types=1);

namespace App\Domain\Model;

class Alert
{
    /** @var Type */
    private $type;

    /** @var Position */
    private $position;

    /**
     * @param Type $type
     * @param Position $position
     */
    public function __construct(Type $type, Position $position)
    {
        $this->type = $type;
        $this->position = $position;
    }

    /**
     * @return Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * @return Position
     */
    public function getPosition(): Position
    {
        return $this->position;
    }
}

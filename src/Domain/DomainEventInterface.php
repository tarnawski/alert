<?php

namespace App\Domain;

interface DomainEventInterface
{
    /**
     * @return string
     */
    public function getAggregateId(): string;

    /**
     * @return string
     */
    public function serialize(): string;
}
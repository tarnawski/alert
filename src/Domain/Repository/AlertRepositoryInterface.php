<?php

namespace App\Domain\Repository;

use App\Domain\Alert;
use App\Infrastructure\Exception\PersistenceException;

interface AlertRepositoryInterface
{
    /**
     * @param Alert $alert
     * @return void
     * @throws PersistenceException
     */
    public function persist(Alert $alert): void;
}

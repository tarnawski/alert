<?php

namespace App\Domain\Repository;

use App\Domain\Alert;
use App\Domain\AlertIdentity;
use App\Infrastructure\Exception\PersistenceException;

interface AlertRepositoryInterface
{
    /**
     * @param AlertIdentity $identity
     * @return Alert
     */
    public function get(AlertIdentity $identity): Alert;

    /**
     * @param Alert $alert
     * @return void
     * @throws PersistenceException
     */
    public function persist(Alert $alert): void;
}

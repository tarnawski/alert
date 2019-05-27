<?php

namespace App\Domain\Repository;

use App\Domain\Model\Alert;
use App\Domain\Model\SearchCriteria;
use App\Infrastructure\Exception\PersistenceException;

interface AlertRepositoryInterface
{
    /**
     * @param SearchCriteria $criteria
     * @return array
     */
    public function findByCriteria(SearchCriteria $criteria): array;

    /**
     * @param Alert $alert
     * @return void
     * @throws PersistenceException
     */
    public function persist(Alert $alert): void;
}

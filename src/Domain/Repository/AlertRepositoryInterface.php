<?php

namespace App\Domain\Repository;

use App\Domain\Model\Alert;
use App\Domain\Model\SearchCriteria;

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
     */
    public function persist(Alert $alert): void;
}

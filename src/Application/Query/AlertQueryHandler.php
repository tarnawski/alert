<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Domain\SearchCriteria;
use App\Domain\Repository\AlertRepositoryInterface;

class AlertQueryHandler
{
    /** @var AlertRepositoryInterface */
    private $alertRepository;

    /**
     * @param AlertRepositoryInterface $alertRepository
     */
    public function __construct(AlertRepositoryInterface $alertRepository)
    {
        $this->alertRepository = $alertRepository;
    }

    /**
     * @param AlertQuery $query
     * @return array|null
     */
    public function handle(AlertQuery $query): ?array
    {
        return $this->alertRepository->findByCriteria(
            new SearchCriteria($query->getLatitude(), $query->getLongitude())
        );
    }
}
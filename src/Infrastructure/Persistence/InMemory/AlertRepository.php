<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory;

use App\Domain\Model\Position;
use Exception;
use DateTime;
use App\Domain\Alert;
use App\Domain\SearchCriteria;
use App\Domain\Repository\AlertRepositoryInterface;

class AlertRepository implements AlertRepositoryInterface
{
    const DEFAULT_LIMIT = 10;

    /** @var array */
    private $storage;

    /**
     * @param array $storage
     */
    public function __construct(array $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param SearchCriteria $criteria
     * @return array
     */
    public function findByCriteria(SearchCriteria $criteria): array
    {
        $results = array_map(function ($alert) use ($criteria){
            return [
                'type' => $alert['type'],
                'latitude' => $alert['latitude'],
                'longitude' => $alert['longitude'],
                'distance' => $this->distanceCalculator(
                    new Position($alert['latitude'], $alert['longitude']),
                    new Position((float) $criteria->getLatitude(), (float) $criteria->getLongitude())
                )
            ];
        }, $this->storage);

        if (null !== $criteria->getType()) {
            $results = array_filter($results, function ($alert) use ($criteria) {
                return $alert['type'] === $criteria->getType();
            });
        }

        usort($results, function ($item1, $item2) {
            return $item1['distance'] <=> $item2['distance'];
        });

        return array_slice($results, 0, self::DEFAULT_LIMIT);
    }

    /**
     * @param Alert $alert
     * @throws Exception
     */
    public function persist(Alert $alert): void
    {
        $this->storage[] = [
            'type' => $alert->getType()->getName(),
            'latitude' => $alert->getPosition()->getLatitude(),
            'longitude' => $alert->getPosition()->getLongitude(),
            'created_at' => new DateTime()
        ];
    }

    /**
     * @param Position $positionFrom
     * @param Position $positionTo
     * @param int $earthRadius
     * @return float|int
     */
    function distanceCalculator(Position $positionFrom, Position $positionTo, int $earthRadius = 6371000)
    {
        $latDelta = deg2rad($positionTo->getLatitude()) - deg2rad($positionFrom->getLatitude());
        $lonDelta = deg2rad($positionTo->getLongitude()) - deg2rad($positionFrom->getLongitude());

        return 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos(deg2rad($positionFrom->getLatitude())) *
               cos(deg2rad($positionTo->getLatitude())) * pow(sin($lonDelta / 2), 2))) * $earthRadius;
    }
}

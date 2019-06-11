<?php

namespace App\Infrastructure\Projection;

use App\Domain\Alert;
use App\Domain\DomainEventInterface;
use App\Domain\Event\AlertConfirmed;
use App\Domain\Event\AlertCreated;
use PDO;
use ReflectionClass;
use ReflectionException;

class PDOAlertProjection
{
    /** @var PDO */
    private $pdo;

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param DomainEventInterface $event
     * @throws ReflectionException
     */
    public function project(DomainEventInterface $event)
    {
        $method = sprintf('project%s', (new ReflectionClass($event))->getShortName());
        $this->$method($event);
    }

    /**
     * @param AlertCreated $event
     */
    public function projectAlertCreated(AlertCreated $event): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO alert (`id`, `type`, `status`, `latitude`, `longitude`)
             VALUES (:id, :type, :status, :latitude, :longitude)'
        );
        $stmt->execute([
            ':id' => (string) $event->getAggregateId(),
            ':type' => $event->getType(),
            ':status' => Alert::STATUS_UNCONFIRMED,
            ':latitude' => $event->getLatitude(),
            ':longitude' => $event->getLongitude(),
        ]);
    }

    /**
     * @param AlertConfirmed $event
     */
    public function projectAlertConfirmed(AlertConfirmed $event): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE alert SET status = :status WHERE id = :id'
        );
        $stmt->execute([
            ':status' => Alert::STATUS_CONFIRMED,
            ':id' => $event->getAggregateId()
        ]);
    }
}
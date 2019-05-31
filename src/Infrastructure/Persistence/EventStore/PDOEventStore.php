<?php

namespace App\Infrastructure\Persistence\EventStore;

use App\Domain\DomainEventInterface;
use App\Domain\IdentityInterface;
use DateTime;
use Exception;
use PDO;

class PDOEventStore implements EventStoreInterface
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
     * @param $identity
     * @return array
     */
    public function getAggregateHistoryForIdentity(IdentityInterface $identity): array
    {
        $events = [];

        $stmt = $this->pdo->prepare('SELECT * FROM event_store WHERE aggregate_id = :aggregate_id');
        $stmt->execute([':aggregate_id' => $identity->getValue()]);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $events[] =  unserialize($row['data']);
        }
        $stmt->closeCursor();

        return $events;
    }

    /**
     * @param DomainEventInterface $event
     * @throws Exception
     */
    public function commit(DomainEventInterface $event): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO event_store (`aggregate_id`, `type`, `data`, `created_at`)
             VALUES (:aggregate_id, :type, :data, :created_at)'
        );
        $stmt->execute([
            ':aggregate_id' => (string) $event->getAggregateId(),
            ':type' => get_class($event),
            ':data' => serialize($event),
            ':created_at' => (new DateTime())->format('Y-m-d H:i:s')
        ]);
    }
}
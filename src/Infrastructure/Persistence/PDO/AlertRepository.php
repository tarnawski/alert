<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\PDO;

use App\Infrastructure\Exception\PersistenceException;
use Exception;
use PDO;
use DateTime;
use App\Domain\Model\Alert;
use App\Domain\Model\SearchCriteria;
use App\Domain\Repository\AlertRepositoryInterface;

class AlertRepository implements AlertRepositoryInterface
{
    const DEFAULT_LIMIT = 10;

    /** @var PDO */
    private $connection;

    /**
     * @param string $databaseUrl
     */
    public function __construct(string $databaseUrl)
    {
        $dns = sprintf(
            '%s:dbname=%s;host=%s',
            parse_url($databaseUrl, PHP_URL_SCHEME),
            ltrim(parse_url($databaseUrl, PHP_URL_PATH), '/'),
            parse_url($databaseUrl, PHP_URL_HOST)
        );

        $this->connection = new PDO(
            $dns,
            parse_url($databaseUrl, PHP_URL_USER),
            parse_url($databaseUrl, PHP_URL_PASS)
        );
    }

    /**
     * @param SearchCriteria $criteria
     * @return array
     */
    public function findByCriteria(SearchCriteria $criteria): array
    {
        $sql = 'SELECT type, latitude, longitude, ( 6371 * acos(cos(radians(' . $criteria->getLatitude() . '))' .
            '* cos( radians( latitude ) )' .
            '* cos( radians( longitude )' .
            '- radians(' . $criteria->getLongitude() . ') )' .
            '+ sin( radians(' . $criteria->getLatitude() . ') )' .
            '* sin( radians( latitude ) ) ) ) as distance 
            FROM alert
            ORDER BY distance
            LIMIT ' . self::DEFAULT_LIMIT;

        $sth = $this->connection->query($sql);

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param Alert $alert
     * @throws PersistenceException
     */
    public function persist(Alert $alert): void
    {
        $sql = 'INSERT INTO alert (type, latitude, longitude, created_at) VALUES (:type, :latitude, :longitude, :created_at)';
        $type = $alert->getType()->getName();
        $latitude = $alert->getPosition()->getLatitude();
        $longitude = $alert->getPosition()->getLongitude();
        $createdAt = (new DateTime())->format('Y-m-d H:i:s');

        try {
            $sth = $this->connection->prepare($sql);
            $sth->bindParam(':type', $type);
            $sth->bindParam(':latitude', $latitude);
            $sth->bindParam(':longitude', $longitude);
            $sth->bindParam(':created_at', $createdAt);
            $sth->execute();
        } catch (Exception $exception) {
            throw new PersistenceException($exception->getMessage());
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Alert;
use App\Domain\Exception\PositionException;
use App\Domain\Exception\TypeException;
use App\Domain\Alert\Position;
use App\Domain\Alert\Type;
use App\Domain\Repository\AlertRepositoryInterface;
use App\Domain\AlertIdentity;
use App\Infrastructure\Exception\PersistenceException;

class AddAlertCommandHandler
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
     * @param AddAlertCommand $command
     */
    public function handle(AddAlertCommand $command): void
    {
        try {
            $alert = Alert::createWithData(
                new AlertIdentity($command->getIdentity()),
                new Type($command->getType()),
                new Position($command->getLatitude(), $command->getLongitude())
            );
        } catch (TypeException | PositionException $exception) {
            // TODO handle exceptions
        }

        try {
            $this->alertRepository->persist($alert);
        } catch (PersistenceException $exception) {
            // TODO handle exceptions
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Alert;
use App\Domain\Exception\PositionException;
use App\Domain\Exception\TypeException;
use App\Domain\Model\Position;
use App\Domain\Model\Type;
use App\Domain\Repository\AlertRepositoryInterface;
use App\Infrastructure\Exception\PersistenceException;

class NotifyAlertCommandHandler
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
     * @param NotifyAlertCommand $command
     */
    public function handle(NotifyAlertCommand $command): void
    {
        try {
            $alert = new Alert(
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

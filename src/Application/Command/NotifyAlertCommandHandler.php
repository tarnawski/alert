<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Model\Alert;
use App\Domain\Model\Position;
use App\Domain\Model\Type;
use App\Domain\Repository\AlertRepositoryInterface;

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
        $alert = new Alert(
            new Type($command->getType()),
            new Position($command->getLatitude(), $command->getLongitude())
        );

        $this->alertRepository->persist($alert);
    }
}

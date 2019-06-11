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

class ConfirmAlertCommandHandler
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
     * @param ConfirmAlertCommand $command
     */
    public function handle(ConfirmAlertCommand $command): void
    {
        $alert = $this->alertRepository->get(new AlertIdentity($command->getIdentity()));
        $alert->confirm();

        try {
            $this->alertRepository->persist($alert);
        } catch (PersistenceException $exception) {
            // TODO handle exceptions
        }
    }
}

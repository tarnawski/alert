<?php

declare(strict_types=1);

namespace App\Presentation\Web\Controller;

use App\Application\Command\AddAlertCommand;
use App\Application\Query\AlertQuery;
use App\Application\ServiceBus\CommandBus;
use App\Application\ServiceBus\QueryBus;
use App\Domain\Alert;
use Exception;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AlertController extends AbstractController
{
    /** @var CommandBus */
    private $commandBus;

    /** @var QueryBus */
    private $queryBus;

    /**
     * @param CommandBus $commandBus
     * @param QueryBus $queryBus
     */
    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    /**
     * @param string $identity
     * @return JsonResponse
     */
    public function showAction(string $identity)
    {
        $query = new AlertQuery($identity);
        /** @var Alert $alert */
        $alert = $this->queryBus->handle($query);

        return $this->json([
            'id' => $alert->getIdentity()->getValue(),
            'type' => $alert->getType()->getName(),
            'latitude' => $alert->getPosition()->getLatitude(),
            'longitude' => $alert->getPosition()->getLongitude()
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function reportAction(Request $request)
    {
        $identity = Uuid::uuid4()->toString();
        $data = json_decode($request->getContent(), true);

        $command = new AddAlertCommand(
            $identity,
            (string) $data['type'],
            (float) $data['latitude'],
            (float) $data['longitude']
        );

        $this->commandBus->handle($command);

        return $this->json([
            'status' => 'success',
            'identity' => $identity
        ], 201);
    }
}
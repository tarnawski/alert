<?php

declare(strict_types=1);

namespace App\Presentation\Web\Controller;

use App\Application\Command\NotifyAlertCommand;
use App\Application\Query\AlertQuery;
use App\Application\ServiceBus\CommandBus;
use App\Application\ServiceBus\QueryBus;
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
     * @param Request $request
     * @return JsonResponse
     */
    public function searchAction(Request $request)
    {
        $query = new AlertQuery(
            $request->get('latitude'),
            $request->get('longitude')
        );

        $result = $this->queryBus->handle($query);

        return $this->json($result);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function reportAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $command = new NotifyAlertCommand(
            (string) $data['type'],
            (float) $data['latitude'],
            (float) $data['longitude']
        );

        $this->commandBus->handle($command);

        return $this->json(['status' => 'success'], 201);
    }
}
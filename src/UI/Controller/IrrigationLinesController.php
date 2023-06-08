<?php

namespace App\UI\Controller;

use App\Domain\Query\IrrigationLinesQuery;
use App\Domain\Query\ValveStateQuery;
use App\Infrastructure\MessageBus\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class IrrigationLinesController extends AbstractController
{
    public function __construct(private readonly QueryBus $queryBus)
    {
    }

    #[Route("/irrigation-lines")]
    public function getLines(): JsonResponse
    {
        $lines = $this->queryBus->runQuery(new IrrigationLinesQuery());
        return new JsonResponse($lines);
    }

    #[Route("/irrigation-lines/{identifier}")]
    public function getState($identifier): JsonResponse
    {
        $state = $this->queryBus->runQuery(new ValveStateQuery((int)$identifier));
        return new JsonResponse($state);
    }
}
<?php

namespace App\UI\Controller;

use App\Domain\Query\IrrigationLinesQuery;
use App\Domain\Query\ValveStateQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

class IrrigationLinesController extends AbstractController
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
    }

    #[Route("/irrigation-lines")]
    public function getLines(): JsonResponse
    {
        $envelope = $this->messageBus->dispatch(new IrrigationLinesQuery());
        $handledStamp = $envelope->last(HandledStamp::class);
        $lines = $handledStamp->getResult();
        return new JsonResponse($lines);
    }

    #[Route("/irrigation-lines/{identifier}")]
    public function getState($identifier): JsonResponse
    {
        $envelope = $this->messageBus->dispatch(new ValveStateQuery((int)$identifier));
        $handledStamp = $envelope->last(HandledStamp::class);
        $state = $handledStamp->getResult();
        return new JsonResponse($state);
    }
}
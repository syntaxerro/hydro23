<?php

namespace App\UI\Controller;

use App\Domain\Entity\Schedule;
use App\Domain\Repository\ScheduleRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScheduleCrudController extends AbstractController
{
    public function __construct(private readonly ScheduleRepositoryInterface $scheduleRepository)
    {
    }

    #[Route("/schedule/", methods: ["PUT"])]
    public function addSchedule(Request $request): Response
    {
        $rawRequest = json_decode($request->getContent(), true);

        $schedule = new Schedule(
            $rawRequest['irrigationLineIdentifier'],
            $rawRequest['startAt'],
            $rawRequest['dayOfWeek'],
            $rawRequest['irrigationTime']
        );

        $this->scheduleRepository->save($schedule);
        return new JsonResponse($schedule);
    }

    #[Route("/schedule/{id}", methods: ["POST"])]
    public function editSchedule(Request $request, $id): Response
    {
        $rawRequest = json_decode($request->getContent(), true);
        $schedule = $this->scheduleRepository->get($id);
        $schedule->setIrrigationLineIdentifier($rawRequest['irrigationLineIdentifier']);
        $schedule->setStartAt($rawRequest['startAt']);
        $schedule->setDayOfWeek($rawRequest['dayOfWeek']);
        $schedule->setIrrigationTime($rawRequest['irrigationTime']);

        $this->scheduleRepository->save($schedule);
        return new JsonResponse($schedule);
    }

    #[Route("/schedule/{id}", methods: ["DELETE"])]
    public function deleteSchedule(Request $request, $id): Response
    {
        $schedule = $this->scheduleRepository->get($id);
        $this->scheduleRepository->delete($schedule);
        return new JsonResponse($schedule);
    }

    #[Route("/schedule", methods: ["GET"])]
    public function listSchedules(): Response
    {
        $all = $this->scheduleRepository->findAll();
        return new JsonResponse($all);
    }
}
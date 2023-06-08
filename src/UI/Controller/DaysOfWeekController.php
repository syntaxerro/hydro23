<?php

namespace App\UI\Controller;

use App\Domain\Entity\Enum\DayOfWeekEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DaysOfWeekController extends AbstractController
{
    #[Route("/day-of-week")]
    public function all(): JsonResponse
    {
        $result = [];
        $names = array_column(DayOfWeekEnum::cases(), 'name');
        $values = array_column(DayOfWeekEnum::cases(), 'value');
        foreach ($values as $i => $value) {
            $result[] = ['name' => $names[$i], 'value' => $value];
        }
        return new JsonResponse($result);
    }
}
<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Repository\ActivityRepository;
use App\Repository\FeaturesValueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/activity')]
class ActivityController extends AbstractController
{
    #[Route('/prepare', name: 'prepare', methods: ['POST'])]
    public function suggestActivity(Request $request, ActivityRepository $activityRepository, FeaturesValueRepository $featuresValueRepository): array
    {
        $inputs = $request->toArray();
        $activities = $featuresValueRepository->findBy(["id"=>$inputs]);
        
        $allActivities = $activityRepository->findSuggest($activities);

        return $allActivities;

    }

    #[Route('/{id}/average', name: 'activity_average', methods: ['GET'])]
    public function averageRate(Activity $activity): JsonResponse
    {
        $reviews = $activity->getReviews();
        $total = 0;
        $count = 0;
        foreach ($reviews as $review) {
            $total += $review->getRate();
            $count++;
        }
        if($count == 0) {
            return new JsonResponse(['error' => 'No rates found for this activity'],200);
        }
        $average = $total/$count;
        return new JsonResponse(['average' => $average],200);
    }

    #[Route('/latest', name: 'latest', methods: ['GET'])]
    public function latest(ActivityRepository $repository): JsonResponse
    {
        $activities = $repository->findLatest();
        return $this->json($activities);
    }

}

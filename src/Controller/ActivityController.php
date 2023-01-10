<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\FeaturesValue;
use App\Form\ActivityType;
use App\Repository\ActivityRepository;
use App\Repository\FeaturesRepository;
use App\Repository\FeaturesValueRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/activity')]
class ActivityController extends AbstractController
{
    #[Route('/', name: 'app_activity_index', methods: ['GET'])]
    public function index(ActivityRepository $activityRepository): Response
    {
        return $this->render('activity/index.html.twig', [
            'activities' => $activityRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_activity_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ActivityRepository $activityRepository): Response
    {
        $activity = new Activity();
        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $activityRepository->add($activity, true);

            return $this->redirectToRoute('app_activity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('activity/new.html.twig', [
            'activity' => $activity,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_activity_show', methods: ['GET'])]
    public function show(Activity $activity): Response
    {
        return $this->render('activity/show.html.twig', [
            'activity' => $activity,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_activity_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Activity $activity, ActivityRepository $activityRepository): Response
    {
        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $activityRepository->add($activity, true);

            return $this->redirectToRoute('app_activity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('activity/edit.html.twig', [
            'activity' => $activity,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_activity_delete', methods: ['POST'])]
    public function delete(Request $request, Activity $activity, ActivityRepository $activityRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$activity->getId(), $request->request->get('_token'))) {
            $activityRepository->remove($activity, true);
        }

        return $this->redirectToRoute('app_activity_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/prepare', name: 'prepare', methods: ['POST'])]
    public function suggestActivity(Request $request, ActivityRepository $activityRepository, FeaturesValueRepository $featuresValueRepository): Response
    {
        $inputs = $request->toArray();
        dd($inputs);
        $activities = $featuresValueRepository->findBy(["id"=>$inputs]);
        //$activitySuggest = $activityRepository->findSuggest($inputs);
        foreach ($activities as $activity) {
            dump($activity);
        }
        dd($activities);

        $allActivities = $activityRepository->findAll();
        //findSuggest($request);

        //return ;
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
        $average = $total/$count;
        return new JsonResponse(['average' => $average],200);
    }

}

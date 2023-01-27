<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Repository\UnitRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
//use Symfony\Component\Routing\Annotation\Route;


class ActivityImageController extends AbstractController
{

    public function __invoke(Request $request, SluggerInterface $slugger, UserRepository $userRepository, UnitRepository $unitRepository)
    {
        $activity = new Activity();
        $activity->hydrate($request->request->all());
        $user = $userRepository->findOneBy(['id'=> $request->request->get('user')]);
        $activity->setUser($user);
        $unit = $unitRepository->findOneBy(['id'=> $request->request->get('unit')]);
        $activity->setUnit($unit);
                

        $file = $request->files->get('picture');
        
        // upload limage
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeFilename = $slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        // Move the file to the target_directory see config/service.yaml
        try {
            $file->move(
                $this->getParameter('activity_directory'),
                $newFilename
            );
        } catch (FileException $e) {
            throw new \Exception("Error Processing UploadFile", 500);
        }
        //$activity = $request->files->get('file');
        $activity->setPicture($this->getParameter('base_url').'/upload/images/activities/'.$newFilename);

        return $activity;
    }
}
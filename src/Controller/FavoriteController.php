<?php

namespace App\Controller;

use App\Entity\Favorite;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


class FavoriteController extends AbstractController
{
    #[Route('/favorites/{id}/', name: 'update_favorite', methods: ['PUT'])]
    public function update(Request $request, Favorite $favorite, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), true);
        $favorite->setIsFavorite($data['isFavorite']);
        $entityManager->flush();

        return $this->json($favorite);
    }

}
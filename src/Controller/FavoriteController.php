<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\FavoriteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class FavoriteController extends AbstractController
{
    /**
     * @Route("/favorite", name="app_favorite")
     * @param FavoriteRepository $favoriteRepository
     * @return Response
     * @IsGranted("ROLE_USER")
     */

    public function show(FavoriteRepository $favoriteRepository): Response
    {
        $user = $this->getUser();

        $favorites = $favoriteRepository->findFavoriteByUser($user);
        return $this->render('favorite/index.html.twig', [
            'favorites' => $favorites
        ]);
    }
}

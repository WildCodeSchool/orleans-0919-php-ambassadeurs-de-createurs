<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/search")
 */
class SearchController extends AbstractController
{
    /**
     * @Route("/{role}", name="search_role", methods={"GET"})
     */
    public function showByRoles(UserRepository $userRepository, string $role): Response
    {
        $users = $userRepository->findBy(['roles' => $role]);

        return $this->render('search/index.html.twig', [
            'users' => $users,
        ]);
    }
}

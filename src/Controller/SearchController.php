<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\User;
use App\Form\SearchType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/search")
 */
class SearchController extends AbstractController
{
    /**
     * @Route("/{role}", name="search_role")
     */
    public function showByRoles(UserRepository $userRepository, string $role, Request $request): Response
    {
//        $data = new SearchData();
        $users = $userRepository->findBy(['roles' => $role]);

        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);


        if ($form->isSubmitted()) {
            $data = $form->getData();
            $users = $userRepository->findSearch($data);
        }

        return $this->render('search/index.html.twig', [
            'users' => $users,
            'role' => $role,
            'form' => $form->createView()
        ]);
    }
}

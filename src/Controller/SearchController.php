<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SearchType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * @Route("/search")
 */
class SearchController extends AbstractController
{
    const NB_MAX_RESULT = 12;

    /**
     * @Route("/{role}/{page}", name="search_role", requirements={"page" = "\d+"}, defaults={"page" = 1})
     */
    public function showByRoles(UserRepository $userRepository, string $role, Request $request, int $page): Response
    {

        $data = [];

        if (!array_key_exists($role, User::ROLES_URL)) {
            throw new Exception('Mauvais rôle');
        }

        $data['roles'] = $role;
        $users = $userRepository->findSearch($data, $page, self::NB_MAX_RESULT);

        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data[] = $form->getData();
            $users = $userRepository->findSearch($data, $page, self::NB_MAX_RESULT);
        }

        return $this->render('search/index.html.twig', [
            'users' => $users,
            'role' => $role,
            'form' => $form->createView()
        ]);
    }
}

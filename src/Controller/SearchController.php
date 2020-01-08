<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Favorite;
use App\Entity\User;
use App\Form\SearchType;
use App\Repository\FavoriteRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
    /**
     * @Route("/{role}", name="search_role")
     */
    public function showByRoles(UserRepository $userRepository, string $role, Request $request): Response
    {

        if (!array_key_exists($role, User::ROLES_URL)) {
            throw new Exception('Mauvais rôle');
        }
        $users = $userRepository->findByRoles(User::ROLES_URL[$role]);
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

    /**
     *
     * @Route("/{id}/like", name="search_like")
     *
     * @param User $userToFollow
     * @param ObjectManager $manager
     * @return Response
     */
    public function like(User $userToFollow, ObjectManager $manager): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            return $this->json([
                'code' => 403,
                'message' => 'Unauthorized'
            ], 403);
        }

        $user = $this->getUser();

        $favorite = new Favorite();
        $favorite->setUserFavorite($userToFollow);
        $favorite->setUser($user);
        $manager->persist($favorite);

        $manager->flush();

        return $this->json([
            'favorites' => count($userToFollow->getFollowers()),
            'message' => 'Like bien ajouté',
        ], 200);
    }
}

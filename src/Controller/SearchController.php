<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Favorite;
use App\Entity\User;
use App\Form\SearchType;
use App\Repository\FavoriteRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
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

    /**
     *
     * @Route("/{id}/like", name="search_like")
     *
     * @param User $userFavorite
     * @param ObjectManager $manager
     * @param FavoriteRepository $favoriteRepository
     * @return Response
     */
    public function like(User $userFavorite, ObjectManager $manager, FavoriteRepository $favoriteRepository): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->json([
            'code' => 403,
            'message' => 'Unauthorized'
            ], 403);
        }

        if ($userFavorite->isLikedByUser($user)) {
            $favorite = $favoriteRepository->findOneBy([
                'user' => $user
            ]);

            $manager->remove($favorite);
            $manager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Like bien supprimé',
                'likes' => $favoriteRepository->count(['user' => $userFavorite])
            ], 200);
        }

        $favorite = new Favorite();
        $favorite->setUserFavorite($userFavorite)
            ->setUser($user);

        $manager->persist($favorite);
        $manager->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Like bien ajouté',
            'likes' => $favoriteRepository->count(['user' => $userFavorite])
        ], 200);
    }
}

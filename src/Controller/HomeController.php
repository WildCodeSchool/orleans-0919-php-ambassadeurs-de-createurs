<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\CoordinateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    const NB_CARDS = 6;
    /**
     * @Route("/", name="home_index")
     */
    public function index(UserRepository $userRepository, CoordinateService $coordinateService): Response
    {
        $roles = User::ROLES;
        $ambassadors = $this->getDoctrine()
            ->getRepository(User::class)
            ->findBy(['roles' => $roles['Ambassadeur']], null, self::NB_CARDS);

        $ambassadorsMarkers = $userRepository->findAll();

        $coordinates = [];
        foreach ($ambassadorsMarkers as $ambassadorsMarker) {
            $coordinates[$ambassadorsMarker->getId()] = $coordinateService
                ->getCoordinates($ambassadorsMarker->getCity() ?? 'Paris');
        }

        return $this->render('/home/index.html.twig', [
            'ambassadors' => $ambassadors,
            'ambassadorsMarkers' => $ambassadorsMarkers,
            'coordinates' => $coordinates,
        ]);
    }
}

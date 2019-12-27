<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\CoordinateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    const NB_CARDS = 6;

    /**
     * @Route("/", name="home_index")
     * @param CoordinateService $coordinateService
     * @return Response
     */
    public function index(CoordinateService $coordinateService): Response
    {
        $roles = User::ROLES;
        $ambassadors = $this->getDoctrine()
            ->getRepository(User::class)
            ->findBy(['roles' => $roles['Ambassadeur']]);
        $cards = array_slice($ambassadors, count($ambassadors)-self::NB_CARDS, self::NB_CARDS);

        $coordinates = [];
//        foreach ($ambassadors as $ambassador) {
//            $coordinates[$ambassador->getId()] = $coordinateService
//                ->getCoordinates($ambassador->getCity());
//        }

        return $this->render('/home/index.html.twig', [
            'ambassadors' => $ambassadors,
            'cards' => $cards,
            'coordinates' => $coordinates,
        ]);
    }
}

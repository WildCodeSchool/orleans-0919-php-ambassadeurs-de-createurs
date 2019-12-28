<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\CoordinateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
        /** @var User[] A user */
        $ambassadors = $this->getDoctrine()
            ->getRepository(User::class)
            ->findBy(['roles' => $roles['Ambassadeur']]);
        $ambassadorCards = array_slice($ambassadors, count($ambassadors)-self::NB_CARDS, self::NB_CARDS);

//        $encoders = [new JsonEncoder()];
//        $normalizers = [new ObjectNormalizer()];
//        $serializer = new Serializer($normalizers, $encoders);

        $coordinates = [];
        foreach ($ambassadors as $ambassador) {
            if (!is_null($ambassador->getCity())) {
                $coordinates[$ambassador->getId()] = $coordinateService
                    ->getCoordinates($ambassador->getCity());
            }
        }

        return $this->render('/home/index.html.twig', [
            'ambassadors' => $ambassadors,
            'ambassadorCards' => $ambassadorCards,
            'coordinates' => $coordinates,
        ]);
    }
}

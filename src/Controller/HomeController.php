<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\CoordinateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class HomeController extends AbstractController
{

    const NB_CARDS = 6;

    /**
     * @Route("/", name="home_index")
     * @param UserRepository $userRepository
     * @param CoordinateService $coordinateService
     * @param NormalizerInterface $normalizer
     * @return Response
     * @throws ExceptionInterface
     */
    public function index(
        UserRepository $userRepository,
        CoordinateService $coordinateService,
        NormalizerInterface $normalizer
    ): Response {

        $roles = User::ROLES;
        $ambassadors = $userRepository->findBy(['rolesLMCO' => $roles['Ambassadeur']]);
        $ambassadorCards = array_slice($ambassadors, count($ambassadors)-self::NB_CARDS, self::NB_CARDS);

        $context = [
            ObjectNormalizer::IGNORED_ATTRIBUTES => ['users', 'mail', 'department']
        ];
        $ambassadorsArray = $normalizer->normalize($ambassadors, 'json', $context);

        for ($i = 0; $i < count($ambassadorsArray); $i++) {
            $ambassadorsArray[$i]['coordinates'] = $coordinateService
                ->getCoordinates($ambassadorsArray[$i]['city']);
        }

        return $this->render('/home/index.html.twig', [
            'ambassadorsArray' => $ambassadorsArray,
            'ambassadorCards' => $ambassadorCards,
        ]);
    }
}

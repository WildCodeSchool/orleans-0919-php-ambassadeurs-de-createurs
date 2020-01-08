<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class HomeController extends AbstractController
{

    const NB_CARDS = 6;

    /**
     * @Route("/", name="home_index")
     * @param UserRepository $userRepository
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function index(UserRepository $userRepository, SerializerInterface $serializer): Response
    {

        $ambassadors = $userRepository->findByRoles(User::ROLE_AMBASSADOR);
        $ambassadorCards = array_slice($ambassadors, count($ambassadors)-self::NB_CARDS, self::NB_CARDS);

        $context = [
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['users', 'user', 'eventsSponsored'],
        ];
        $ambassadorsJson = $serializer->serialize($ambassadors, 'json', $context);

        return $this->render('/home/index.html.twig', [
            'ambassadors' => $ambassadorsJson,
            'ambassadorCards' => $ambassadorCards,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    const NB_CARDS = 6;
    /**
     * @Route("/", name="home_index")
     */
    public function index(): Response
    {
        $roles = User::ROLES;
        $ambassadors = $this->getDoctrine()
            ->getRepository(User::class)
            ->findBy(['roles' => $roles['Ambassadeur']], null, self::NB_CARDS);

        return $this->render('/home/index.html.twig', ['ambassadors' => $ambassadors]);
    }
}

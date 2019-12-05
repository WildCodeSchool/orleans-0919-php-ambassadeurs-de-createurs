<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_index")
     */
    public function index(): Response
    {
        $ambassadors = $this->getDoctrine()
            ->getRepository(User::class)
            ->findBy(['roles' => 'ambassadeur'], null, 3);

        return $this->render('/home/index.html.twig', ['ambassadors' => $ambassadors]);
    }
}

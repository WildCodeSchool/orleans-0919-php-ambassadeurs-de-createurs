<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\User;
use App\Form\UserInscriptionType;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Security\LoginFormAuthenticator;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user, EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findBy(['user' => $user]);
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'events' => $events
        ]);
    }
}

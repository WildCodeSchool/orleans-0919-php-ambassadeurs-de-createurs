<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserInscriptionType;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        $options = ['user' => $user];
        $view = 'user/';
        if (in_array(User::ROLE_AMBASSADOR, $user->getRoles())) {
            $events = $eventRepository->findBy(['user' => $user]);
            $view .= 'show_ambassador.html.twig';
            $options['events'] = $events;
        } elseif (in_array(User::ROLE_CREATOR, $user->getRoles())) {
            $view .= 'show_creator.html.twig';
        }

        return $this->render($view, $options);
    }
}

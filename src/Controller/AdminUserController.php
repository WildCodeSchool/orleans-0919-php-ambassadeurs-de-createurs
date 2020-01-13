<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\User;
use App\Form\UserInscriptionType;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use App\Service\CoordinateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Security\LoginFormAuthenticator;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

/**
 * @Route("admin/user")
 */
class AdminUserController extends AbstractController
{
    /**
     * @Route("/", name="admin_user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }


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

    /**
     * @Route("/{id}/edit", name="admin_user_edit", methods={"GET","POST"})
     */
    public function edit(
        Request $request,
        User $user,
        CoordinateService $coordinateService,
        UserRepository $userRepository
    ): Response {

        $form = $this->createForm(UserInscriptionType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $city = $request->request->get('user')['city'];
            $coordinates = $coordinateService->getCoordinates($city);

            if (!is_null($coordinates)) {
                $user->setLatitude($coordinates[0]);
                $user->setLongitude($coordinates[1]);
            }
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_user_index');
    }
}

<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\User;
use App\Form\EventType;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use App\Service\CoordinateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/event")
 */
class EventController extends AbstractController
{

    /**
     * @Route("/new", name="event_new", methods={"GET","POST"})
     */
    public function new(
        Request $request,
        CoordinateService $coordinateService,
        UserRepository $userRepository
    ): Response {
        $event = new Event();
        $event->setUser($this->getUser());
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $city = $request->request->get('event')['place'];
            $coordinates = $coordinateService->getCoordinates($city);
            $event->setLatitude($coordinates[0]);
            $event->setLongitude($coordinates[1]);
            $entityManager->persist($event);
            $entityManager->flush();
            if (!isset($coordinates[0]) || !isset($coordinates[1])) {
                $this->addFlash('danger', 'Les coordonnées de votre ville n\'ont paa pu être trouvées.');
            } else {
                $this->addFlash('success', 'Votre événement a été créé');
            }
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('event/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/edit", name="event_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Event $event, CoordinateService $coordinateService): Response
    {
        $user = $this->getUser();

        if ($user === $event->getUser()) {
            $form = $this->createForm(EventType::class, $event);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $city = $request->request->get('event')['place'];
                $coordinates = $coordinateService->getCoordinates($city);
                $event->setLatitude($coordinates[0]);
                $event->setLongitude($coordinates[1]);
                $entityManager->persist($event);
                $entityManager->flush();
                if (!isset($coordinates[0]) || !isset($coordinates[1])) {
                    $this->addFlash('danger', 'Les coordonnées de votre ville n\'ont paa pu être trouvées.');
                } else {
                    $this->addFlash('success', 'Votre événement a été modifié');
                }
                return $this->redirectToRoute('app_profile');
            }

            return $this->render('event/edit.html.twig', [
                'event' => $event,
                'form' => $form->createView(),
            ]);
        } else {
            $this->addFlash('danger', 'Vous ne pouvez pas modifier cet évènement.');
            return $this->redirectToRoute('app_profile');
        }
    }

    /**
     * @Route("/{id}", name="event_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Event $event): Response
    {
        $user = $this->getUser();
        if ($user === $event->getUser()) {
            if ($this->isCsrfTokenValid('delete' . $event->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($event);
                $entityManager->flush();
                $this->addFlash('danger', 'Votre événement a été supprimé.');
            }

            return $this->redirectToRoute('app_profile');
        } else {
            $this->addFlash('danger', 'Vous ne pouvez pas supprimer cet évènement.');
            return $this->redirectToRoute('app_profile');
        }
    }
}

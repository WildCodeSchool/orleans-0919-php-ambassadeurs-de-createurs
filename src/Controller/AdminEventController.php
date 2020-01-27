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
 * @Route("admin/event")
 */
class AdminEventController extends AbstractController
{
    /**
     * @Route("/", name="admin_event_index", methods={"GET"})
     */
    public function index(EventRepository $eventRepository): Response
    {
        return $this->render('event/index.html.twig', [
            'events' => $eventRepository->findBy([], ['dateTime' => 'DESC']),
        ]);
    }


    /**
     * @Route("/{id}", name="admin_event_show", methods={"GET"})
     */
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_event_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Event $event, CoordinateService $coordinateService): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $city = $request->request->get('event')['place'];
            $coordinates = $coordinateService->getCoordinates($city);
            if (!is_null($coordinates)) {
                $event->setLatitude($coordinates[0]);
                $event->setLongitude($coordinates[1]);
            }
            $entityManager->persist($event);
            $entityManager->flush();
            if (!isset($coordinates[0]) || !isset($coordinates[1])) {
                $this->addFlash('danger', 'Les coordonnées de votre ville n\'ont pas pu être trouvées.');
            } else {
                $this->addFlash('success', 'Votre événement a été modifié');
            }
            return $this->redirectToRoute('admin_event_index');
        }

        return $this->render('event/admin_edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_event_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Event $event): Response
    {
        if ($this->isCsrfTokenValid('delete' . $event->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
            $this->addFlash('danger', 'Votre événement a été supprimé');
        }

        return $this->redirectToRoute('admin_event_index');
    }
}

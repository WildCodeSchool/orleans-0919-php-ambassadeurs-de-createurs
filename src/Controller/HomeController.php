<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\BrandRepository;
use App\Repository\EventRepository;
use App\Repository\FavoriteRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \DrewM\MailChimp\MailChimp;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class HomeController extends AbstractController
{
    const NB_CARDS = 6;

    /**
     * @Route("/", name="home_index")
     * @param Request $request
     * @param UserRepository $userRepository
     * @param BrandRepository $brandRepository
     * @return Response
     * @throws \Exception
     */
    public function index(
        Request $request,
        UserRepository $userRepository,
        EventRepository $eventRepository,
        BrandRepository $brandRepository
    ): Response {
        $form = $this->createFormBuilder()
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['placeholder' => 'John'],
            ])
            ->add('mail', EmailType::class, [
                'label' => 'E-mail',
                'attr' => ['placeholder' => 'exemple@mail.fr'],
            ])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newsletterData = $form->getData();
            $mailChimp = new MailChimp($this->getParameter('mailchimp_api_key'));
            $listId = $mailChimp->get('lists')['lists'][0]['id'];
            $mailChimp->post('lists/' . $listId . '/members', [
                'email_address' => $newsletterData['mail'],
                'merge_fields' => ['FNAME' => $newsletterData['firstname']],
                'status' => 'subscribed',
            ]);
            if ($mailChimp->success()) {
                $this->addFlash('success', 'Votre inscription à la lettre d\'information a bien été prise en compte.');
            } else {
                $this->addFlash('danger', 'Votre inscription à la lettre d\'information n\'a pas fonctionné');
            }
            return $this->redirectToRoute('home_index');
        }

        $ambassadors = $userRepository->findMapInfoUsers(User::ROLE_AMBASSADOR);
        $events = $eventRepository->findMapInfoEvents();
        $ambassadorCards = $userRepository->findByMostFavorites(User::ROLE_AMBASSADOR);
        $creators = $brandRepository->findChosenCreator();

        return $this->render('/home/index.html.twig', [
            'ambassadors' => $ambassadors,
            'events' => $events,
            'ambassadorCards' => $ambassadorCards,
            'creators' => $creators,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/unsubscribe", name="home_unsubscribe_newsletter")
     * @return Response
     * @throws \Exception
     */
    public function unsubscribeNewsletter(Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('mail', EmailType::class, [
                'label' => 'E-mail',
                'attr' => ['placeholder' => 'exemple@mail.fr'],
            ])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newsletterData = $form->getData();

            $mailChimp = new MailChimp($this->getParameter('mailchimp_api_key'));
            $listId = $mailChimp->get('lists')['lists'][0]['id'];
            $subscriberHash = MailChimp::subscriberHash($newsletterData['mail']);
            $mailChimp->delete("lists/$listId/members/$subscriberHash");

            if ($mailChimp->success()) {
                $this->addFlash('success', 'Votre inscription à la lettre d\'information a bien été annulée.');
            } else {
                $this->addFlash('danger', 'Votre désinscription à la lettre d\'information n\'a pas fonctionné');
            }
            return $this->redirectToRoute('home_index');
        }

        return $this->render('/home/unsubscribe_newsletter.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

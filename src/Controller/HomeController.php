<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\BrandRepository;
use App\Repository\FavoriteRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use \DrewM\MailChimp\MailChimp;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class HomeController extends AbstractController
{
    const NB_CARDS = 6;

    /**
     * @Route("/", name="home_index")
     * @param Request $request
     * @param UserRepository $userRepository
     * @param SerializerInterface $serializer
     * @param BrandRepository $brandRepository
     * @param FavoriteRepository $favoriteRepository
     * @return Response
     * @throws \Exception
     */
    public function index(
        Request $request,
        UserRepository $userRepository,
        SerializerInterface $serializer,
        BrandRepository $brandRepository,
        FavoriteRepository $favoriteRepository
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

        $ambassadors = $userRepository->findByRoles(User::ROLE_AMBASSADOR);
        $ambassadorCards = array_slice($ambassadors, count($ambassadors) - self::NB_CARDS, self::NB_CARDS);
        $context = [
            AbstractNormalizer::IGNORED_ATTRIBUTES => [
                'users',
                'user',
                'sponsoredEvents',
                'userFavorite',
                'pictureFile',
                'updatedAt'],
        ];
        $ambassadorsJson = $serializer->serialize($ambassadors, 'json', $context);
        $creators = $brandRepository->findChosenCreator();
        
        return $this->render('/home/index.html.twig', [
            'ambassadors' => $ambassadorsJson,
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

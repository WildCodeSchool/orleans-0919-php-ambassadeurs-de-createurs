<?php

namespace App\Controller;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Validator\Constraint;
use App\Form\ResettingType;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use \DateTime;

/**
 * @Route("/renouvellement-mot-de-passe")
 */
class ResettingController extends AbstractController
{
    /**
     * @Route("/requete", name="request_resetting")
     */
    public function request(
        Request $request,
        TokenGeneratorInterface $tokenGenerator,
        UserRepository $userRepository,
        MailerInterface $mailer
    ) {
        $form = $this->createFormBuilder()
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank()
                ]])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $user = $userRepository->findOneBy(['mail' => $form->getData()['email']]);
            if (!$user) {
                $this->addFlash('warning', "Cet email n'existe pas.");
                return $this->redirectToRoute("request_resetting");
            }

            // création du token
            $user->setToken($tokenGenerator->generateToken());
            // enregistrement de la date de création du token
            $user->setPasswordRequestedAt(new DateTime());
            $manager->flush();


            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to($user->getMail())
                ->subject('Réinitialisation mot de passe')
                ->html($this->renderView('resetting/mail.html.twig', [
                    'user' => $user
                ]));

            $mailer->send($email);
            $this->addFlash(
                'success',
                "Un mail va vous être envoyé
                 afin que vous puissiez renouveller votre mot de passe. Le lien que vous recevrez sera valide 24h."
            );

            return $this->redirectToRoute("home_index");
        }

        return $this->render('resetting/request.html.twig', [
            'form' => $form->createView()
        ]);
    }

    // si supérieur à 24h, retourne false
    // sinon retourne false
    private function isRequestInTime(\DateTime $passwordRequestedAt = null)
    {
        if ($passwordRequestedAt === null) {
            return false;
        }

        $now = new DateTime();
        $interval = $now->getTimestamp() - $passwordRequestedAt->getTimestamp();

        $daySeconds = 86400;

        return $interval <= $daySeconds;
    }

    /**
     * @Route("/{id}/{token}", name="resetting")
     */
    public function resetting(User $user, $token, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        if ($user->getToken() === null
            || $token !== $user->getToken()
            || !$this->isRequestInTime($user->getPasswordRequestedAt())) {
            throw new AccessDeniedHttpException();
        }

        $form = $this->createForm(ResettingType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->getData()->getPlainPassword();
            $encoded = $passwordEncoder->encodePassword($user, $password);
            $user->setPassword($encoded);

            $user->setToken(null);
            $user->setPasswordRequestedAt(null);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', "Votre mot de passe a été renouvelé.");

            return $this->redirectToRoute('home_index');
        }
        return $this->render('resetting/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Component\Validator\Constraint;
use App\Form\ResettingType;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Service\Mailer;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Validator\Constraints\Email;
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
        Mailer $mailer,
        TokenGeneratorInterface $tokenGenerator,
        UserRepository $userRepository
    ) {
        // création d'un formulaire "à la volée", afin que l'internaute puisse renseigner son mail
        $form = $this->createFormBuilder()
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Email(),
                    new NotBlank()
                ]])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $user = $userRepository->findOneBy(['mail' => $form->getData()['email']]);
            // aucun email associé à ce compte.
            if (!$user) {
                $this->addFlash('warning', "Cet email n'existe pas.");
                return $this->redirectToRoute("request_resetting");
            }

            // création du token
            $user->setToken($tokenGenerator->generateToken());
            // enregistrement de la date de création du token
            $user->setPasswordRequestedAt(new DateTime());
            $manager->flush();

            // on utilise le service Mailer créé précédemment
            $bodyMail = $mailer->createBodyMail('resetting/mail.html.twig', [
                'user' => $user
            ]);
            $mailer->sendMessage(
                'from@email.com',
                $user->getMail(),
                'renouvellement du mot de passe',
                $bodyMail
            );
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

    // si supérieur à 10min, retourne false
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
        // interdit l'accès à la page si:
        // le token associé au membre est null
        // le token enregistré en base et le token présent dans l'url ne sont pas égaux
        // le token date de plus de 10 minutes
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


            // réinitialisation du token à null pour qu'il ne soit plus réutilisable
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

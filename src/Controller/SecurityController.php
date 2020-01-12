<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfilType;
use App\Form\UserInscriptionType;
use App\Repository\UserRepository;
use App\Security\LoginFormAuthenticator;
use App\Service\CoordinateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use \DateTime;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home_index');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        GuardAuthenticatorHandler $guardHandler,
        LoginFormAuthenticator $authenticator,
        CoordinateService $coordinateService
    ) {
        $user = new User();
        $form = $this->createForm(UserInscriptionType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user->setRoles([$request->request->get('user_inscription')['role']]);
            $user->setUpdatedAt(new DateTime());
            $coordinates = $coordinateService->getCoordinates($user->getCity());
            if ($coordinates !== null) {
                $user->setLatitude($coordinates[0]);
                $user->setLongitude($coordinates[1]);
            }
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/profil", name="app_profile")
     */
    public function profile() :Response
    {
        $user = $this->getUser();
        return $this->render('security/profile.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/profil/modification", name="app_profileEdit")
     */
    public function editProfile(Request $request) :Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfilType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Votre profil a été modifié.');
            return $this->redirectToRoute('app_profile');
        }
        return $this->render('security/editProfile.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}

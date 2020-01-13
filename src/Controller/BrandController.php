<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Form\BrandType;
use App\Repository\BrandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/brand")
 */
class BrandController extends AbstractController
{

    /**
     * @Route("/new", name="brand_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user =  $this->getUser();
        $brand = new Brand();
        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $brand->setUser($user);
            $entityManager->persist($brand);
            $entityManager->flush();
            $this->addFlash('success', 'Votre marque a été créée');
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('brand/new.html.twig', [
            'brand' => $brand,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="brand_show", methods={"GET"})
     */
    public function show(Brand $brand): Response
    {
        return $this->render('brand/show.html.twig', [
            'brand' => $brand,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="brand_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Brand $brand): Response
    {
        $user = $this->getUser();
        if ($user === $brand->getUser()) {
            $form = $this->createForm(BrandType::class, $brand);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', 'Votre marque a été modifiée');
                return $this->redirectToRoute('app_profile');
            }

            return $this->render('brand/edit.html.twig', [
                'brand' => $brand,
                'form' => $form->createView(),
            ]);
        } else {
            $this->addFlash('danger', 'Vous ne pouvez pas modifier cette marque.');
            return $this->redirectToRoute('app_profile');
        }
    }

    /**
     * @Route("/{id}", name="brand_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Brand $brand): Response
    {
        if ($this->isCsrfTokenValid('delete'.$brand->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($brand);
            $entityManager->flush();
            $this->addFlash('danger', 'Votre marque a été supprimée');
        }

        return $this->redirectToRoute('app_profile');
    }
}

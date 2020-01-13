<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Form\BrandType;
use App\Form\ChosenCreatorType;
use App\Repository\BrandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactory;

/**
 * @Route("/brand")
 */
class BrandController extends AbstractController
{
    /**
     * @Route("/", name="brand_index", methods={"GET","POST"})
     * @param BrandRepository $brandRepository
     * @param Request $request
     * @return Response
     */
    public function index(BrandRepository $brandRepository, Request $request): Response
    {
        /**
         * @var FormFactory
         */
        $formFactory = $this->get('form.factory');
        $brands = $brandRepository->findAll();
        $chosenCreator = count($brandRepository->findBy(['chosenCreator' => true]));
        $views = [];
        foreach ($brands as $key => $brand) {
            $form = $formFactory->createNamed('chosen_creator_' . $key, ChosenCreatorType::class, $brand);
            $form->handleRequest($request);
            $views[] = $form->createView();

            if ($form->isSubmitted() && $form->isValid()) {
                if ($chosenCreator > 5 && $brand->getChosenCreator() === true) {
                    $this->addFlash('danger', '6 Créateurs sont déjà affichés sur la page d\'accueil');
                    return $this->redirectToRoute('brand_index');
                } elseif ($chosenCreator > 5 && $brand->getChosenCreator() === false) {
                    $this->getDoctrine()->getManager()->flush();
                    $this->addFlash('success', 'Votre créateur a été retiré de la page d\'accueil');
                    return $this->redirectToRoute('brand_index');
                } elseif ($brand->getChosenCreator() === false) {
                    $this->getDoctrine()->getManager()->flush();
                    $this->addFlash('success', 'Votre créateur a été retiré de la page d\'accueil');
                    return $this->redirectToRoute('brand_index');
                }
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', 'Votre créateur a été mis en avant et sera affiché sur la page d\'accueil');
                return $this->redirectToRoute('brand_index');
            }
        }
        return $this->render('brand/index.html.twig', [
            'brands' => $brands,
            'forms' => $views,
        ]);
    }

    /**
     * @Route("/new", name="brand_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $brand = new Brand();
        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($brand);
            $entityManager->flush();
            $this->addFlash('success', 'Votre marque a été créée');
            return $this->redirectToRoute('brand_index');
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
        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Votre marque a été modifiée');
            return $this->redirectToRoute('brand_index');
        }

        return $this->render('brand/edit.html.twig', [
            'brand' => $brand,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="brand_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Brand $brand): Response
    {
        if ($this->isCsrfTokenValid('delete' . $brand->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($brand);
            $entityManager->flush();
        }

        return $this->redirectToRoute('brand_index');
    }
}

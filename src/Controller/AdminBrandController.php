<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Form\BrandType;
use App\Form\ChosenCreatorType;
use App\Form\HasSubscribeType;
use App\Repository\BrandRepository;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/brand")
 */
class AdminBrandController extends AbstractController
{

    private function formChosenCreators(
        BrandRepository $brandRepository,
        Request $request,
        $formChosenCreator,
        $brand
    ) {
        $chosenCreator = count($brandRepository->findBy(['chosenCreator' => true]));
        $formChosenCreator->handleRequest($request);
        if ($formChosenCreator->isSubmitted() && $formChosenCreator->isValid()) {
            if ($chosenCreator > self::MAX_ON_HOMEPAGE && $brand->getChosenCreator() === true) {
                $this->addFlash(
                    'danger',
                    self::MAX_ON_HOMEPAGE + 1 . ' Créateurs sont déjà affichés sur la page d\'accueil'
                );
                return $this->redirectToRoute('brand_index');
            }

            if ($brand->getChosenCreator() === false) {
                $this->addFlash('success', 'Votre créateur a été retiré de la page d\'accueil');
            } else {
                $this->addFlash(
                    'success',
                    'Votre créateur a été mis en avant et sera affiché sur la page d\'accueil'
                );
            }

            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('brand_index');
        }
    }

    private function formHasSubscribes(BrandRepository $brandRepository, Request $request, $formHasSubscribe, $brand)
    {
        $formHasSubscribe->handleRequest($request);

        if ($formHasSubscribe->isSubmitted() && $formHasSubscribe->isValid()) {
            if ($brand->getHasSubscribe() === true) {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', $brand->getName() . ' s\'est abonné');
                return $this->redirectToRoute('brand_index');
            }
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('danger', $brand->getName() . ' s\'est désabonné');
            return $this->redirectToRoute('brand_index');
        }
    }
    const MAX_ON_HOMEPAGE = 5;

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
        $viewsChosenCreator = [];
        $viewsHasSubscribe = [];

        foreach ($brands as $key => $brand) {
            $formChosenCreator = $formFactory->createNamed('chosen_creator_' . $key, ChosenCreatorType::class, $brand);
            $viewsChosenCreator[] = $formChosenCreator->createView();
            $formHasSubscribe = $formFactory->createNamed('has_subscribe_' . $key, HasSubscribeType::class, $brand);
            $viewsHasSubscribe[] = $formHasSubscribe->createView();
            $this->formChosenCreators($brandRepository, $request, $formChosenCreator, $brand);
            $this->formHasSubscribes($brandRepository, $request, $formHasSubscribe, $brand);
        }
        return $this->render('brand/index.html.twig', [
            'brands' => $brands,
            'formsChosenCreators' => $viewsChosenCreator,
            'formsHasSubscribes' => $viewsHasSubscribe,
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
     * @Route("/{id}/edit", name="admin_brand_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Brand $brand): Response
    {
        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Votre marque a été modifiée');
            return $this->redirectToRoute('admin_brand_index');
        }

        return $this->render('brand/admin_edit.html.twig', [
            'brand' => $brand,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_brand_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Brand $brand): Response
    {
        if ($this->isCsrfTokenValid('delete'.$brand->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($brand);
            $entityManager->flush();
            $this->addFlash('danger', 'Votre marque a été supprimée');
        }

        return $this->redirectToRoute('brand_index');
    }
}

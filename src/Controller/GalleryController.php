<?php

namespace App\Controller;

use App\Entity\Gallery;
use App\Form\GalleryType;
use App\Repository\GalleryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/gallery")
 */
class GalleryController extends AbstractController
{
    /**
     * @Route("/", name="gallery_index", methods={"GET", "POST"})
     */
    public function index(Request $request, GalleryRepository $galleryRepository): Response
    {
        $brand = $this->getUser()->getBrand();
        $galleries = $galleryRepository->findBy(['galleryOwner' => $brand]);
        $gallery = new Gallery();
        $form = $this->createForm(GalleryType::class, $gallery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $gallery->setGalleryOWner($brand);
            $entityManager->persist($gallery);
            $entityManager->flush();
            $this->addFlash('success', 'Votre image a été ajoutée à la galerie');
            return $this->redirectToRoute('gallery_index');
        }

        return $this->render('gallery/index.html.twig', [
            'galleries' => $galleries,
            'gallery' => $gallery,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="gallery_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Gallery $gallery): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gallery->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($gallery);
            $entityManager->flush();
            $this->addFlash('danger', 'Votre photo a été supprimée');
        }

        return $this->redirectToRoute('gallery_index');
    }
}

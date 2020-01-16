<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Form\BlogType;
use App\Repository\BlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \DateTime;

/**
 * @Route("admin/blog")
 */
class AdminBlogController extends AbstractController
{


    /**
     * @Route("/", name="admin_blog_index", methods={"GET"})
     */
    public function indexBlog(BlogRepository $blogRepository): Response
    {
        return $this->render('blog/admin_blog_index.html.twig', [
            'blogs' => $blogRepository->findBy([], ['date' => 'DESC']),
        ]);
    }

    /**
     * @Route("/new", name="admin_blog_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $blog = new Blog();
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $blog->setUpdatedAt(new DateTime());
            $entityManager->persist($blog);
            $entityManager->flush();
            $this->addFlash('success', 'Votre article a été créé');
            return $this->redirectToRoute('admin_blog_index');
        }

        return $this->render('blog/new.html.twig', [
            'blog' => $blog,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="admin_blog_show", methods={"GET"})
     */
    public function show(Blog $blog): Response
    {
        return $this->render('blog/admin_blog_show.html.twig', [
            'blog' => $blog,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="admin_blog_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Blog $blog): Response
    {
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Votre article a été modifié');
            return $this->redirectToRoute('admin_blog_index');
        }

        return $this->render('blog/edit.html.twig', [
            'blog' => $blog,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="admin_blog_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Blog $blog): Response
    {
        if ($this->isCsrfTokenValid('delete' . $blog->getSlug(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($blog);
            $entityManager->flush();
            $this->addFlash('danger', 'Votre article a été supprimé');
        }
        return $this->redirectToRoute('admin_blog_index');
    }
}

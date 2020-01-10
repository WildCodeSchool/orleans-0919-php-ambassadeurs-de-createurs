<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Form\BlogType;
use App\Repository\BlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    const NB_MAX_ARTICLES = 7;


    /**
     * @Route("/{page}", name="blog_index", methods={"GET"}, requirements={"page" = "\d+"}, defaults={"page" = 1})
     */
    public function index(BlogRepository $blogRepository, int $page): Response
    {
        $nbArticles = count($blogRepository->findAllSortAndPage());
        $articles = $blogRepository->findAllSortAndPage($page);

        return $this->render('blog/index.html.twig', [
            'articles' => $articles,
            'page' => $page,
            'nbPages' => ceil($nbArticles / self::NB_MAX_ARTICLES),
        ]);
    }

    /**
     * @Route("/{slug}", name="blog_show", methods={"GET"})
     */
    public function show(Blog $blog): Response
    {
        return $this->render('blog/show.html.twig', [
            'blog' => $blog,
        ]);
    }
}

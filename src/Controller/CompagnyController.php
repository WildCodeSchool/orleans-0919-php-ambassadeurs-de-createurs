<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("compagny")
 */
class CompagnyController extends AbstractController
{
    /**
     * @Route("/concept", name="compagny_concept")
     */
    public function showConcept()
    {
        return $this->render('compagny/concept_index.html.twig');
    }

    /**
     * @Route("/cgv", name="compagny_cgv")
     */
    public function showCGV()
    {
        return $this->render('compagny/cgv_index.html.twig');
    }

    /**
     * @Route("/cgu", name="compagny_cgu")
     */
    public function showCGU()
    {
        return $this->render('compagny/cgu_index.html.twig');
    }
}

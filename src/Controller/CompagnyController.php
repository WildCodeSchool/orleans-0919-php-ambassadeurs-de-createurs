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
     * @Route("/concept", name="app_concept")
     */
    public function show()
    {
        return $this->render('compagny/concept_index.html.twig');
    }
}

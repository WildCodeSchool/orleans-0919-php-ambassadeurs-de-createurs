<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ConceptController extends AbstractController
{
    /**
     * @Route("/concept", name="app_concept")
     */
    public function show()
    {
        return $this->render('concept/index.html.twig');
    }
}

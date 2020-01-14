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

    /**
     * @Route("/concept/createur", name="concept_creator")
     */
    public function showCreatorConcept()
    {
        return $this->render('concept/concept_creator.html.twig');
    }

    /**
     * @Route("/concept/ambassadeur", name="concept_ambassador")
     */
    public function showAmbassadorConcept()
    {
        return $this->render('concept/concept_ambassador.html.twig');
    }
}

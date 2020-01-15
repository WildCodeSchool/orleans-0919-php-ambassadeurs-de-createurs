<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("company")
 */
class CompanyController extends AbstractController
{
    /**
     * @Route("/concept", name="company_concept")
     */
    public function showConcept()
    {
        return $this->render('company/concept_index.html.twig');
    }

    /**
     * @Route("/cgv", name="company_cgv")
     */
    public function showCGV()
    {
        return $this->render('company/cgv_index.html.twig');
    }

    /**
     * @Route("/cgu", name="company_cgu")
     */
    public function showCGU()
    {
        return $this->render('company/cgu_index.html.twig');
    }

    /**
     * @Route("/legalMentions", name="company_legal_mentions")
     */
    public function showLegalMentions()
    {
        return $this->render('company/legal_mentions_index.html.twig');
    }

    /**
     * @Route("/confidentiality", name="company_confidentiality")
     */
    public function showConfidentiality()
    {
        return $this->render('company/confidentiality_index.html.twig');
    }
}

<?php

namespace App\Controller;

use App\Repository\QuestionCategoryRepository;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    /**
     * @Route("/question", name="question")
     */
    public function index(QuestionRepository $questionRepo, QuestionCategoryRepository $categoryRepo)
    {
        $questions = $questionRepo->findAll();
        $categories = $categoryRepo->findAll();

        return $this->render('question/index.html.twig', [
            'questions' => $questions,
            'categories' => $categories,
        ]);
    }
}

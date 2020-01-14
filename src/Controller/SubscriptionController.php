<?php


namespace App\Controller;

use App\Repository\SubscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/subscription")
 */
class SubscriptionController extends AbstractController
{
    /**
     * @Route("/", name="sub_index")
     */
    public function index(SubscriptionRepository $subRepository): Response
    {
        $prices = $subRepository->findOneBy([]);
        return $this->render('subscription/index.html.twig', [
            'prices' => $prices,
        ]);
    }
}

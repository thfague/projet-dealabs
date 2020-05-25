<?php

namespace App\Controller;

use App\Entity\Deal;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DealController extends AbstractController
{
    /**
     * @Route("/", name="app_deals_list")
     */
    public function listDeals()
    {
        $repository = $this->getDoctrine()->getRepository(Deal::class);
        $deals = $repository->findAll();
        return $this->render('homepage.html.twig', ['deals' => $deals]);
    }

}
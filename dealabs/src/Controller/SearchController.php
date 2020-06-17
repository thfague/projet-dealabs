<?php

namespace App\Controller;

use App\Repository\DealRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{

    /**
     * @Route("/recherche", name="app_recherche")
     */
    public function rechercher(Request $request, DealRepository $dealRepository)
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $criterias = $form->getData();
            $deals = $dealRepository->searchByKeywords($criterias);
            //ne se met pas à jour => trouver pourquoi
            return $this->render('search/result.html.twig', ['deals' => $deals]);
            //return $this->redirect($this->generateUrl('app_recherche_criterias', array('criterias' => $criterias)));
        }

        return $this->render('navbar.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}

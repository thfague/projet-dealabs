<?php

namespace App\Controller;

use App\Entity\Deal;
use App\Entity\DealType;
use App\Form\Type\BonPlanType;
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

    /**
     * @Route("/bons-plans/{id}", name="app_single_bonplan")
     */
    public function singleBonPlan($id)
    {
        $deal = $this->getDoctrine()
            ->getRepository(Deal::class)
            ->find($id);
        if(!$deal) {
            throw $this->createNotFoundException(
                'No deal found for id '.$id
            );
        }
        return $this->render('deal/bonplan/show.html.twig', ['deal' => $deal]);
    }

    /**
     * @Route("/deal/createBonPlan", name="app_deal_createBonPlan")
     */
    public function createBonPlan(Request $request){
        $bonPlan = new Deal();
        /*$repository = $this->getDoctrine()->getRepository(DealType::class);
        $typeBonPlan = $repository->findBy(array('nom' => 'bon plan'));
        $bonPlan->setType($typeBonPlan);*/
        $form = $this->createForm(BonPlanType::class, $bonPlan);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $bonPlan = $form->getData();
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($bonPlan);
            $manager->flush();

            //à changer
            return $this->redirect($this->generateUrl('app_deals_list'));
        }

        return $this->render('deal/createBonPlan.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
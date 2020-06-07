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
     * @Route("/bons-plans/{id}", name="app_bonplan_single", requirements={"id"="\d+"})
     */
    public function singleBonPlan(int $id)
    {
        $deal = $this->getDoctrine()
            ->getRepository(Deal::class)
            ->find($id);
        if(!$deal) {
            throw $this->createNotFoundException(
                'No deal found for id '.$id
            );
        }
        return $this->render('bonplan/show.html.twig', ['deal' => $deal]);
    }

    /**
     * @Route("/codes-promo/{id}", name="app_codepromo_single", requirements={"id"="\d+"})
     */
    public function singleCodePromo(int $id)
    {
        $deal = $this->getDoctrine()
            ->getRepository(Deal::class)
            ->find($id);
        if(!$deal) {
            throw $this->createNotFoundException(
                'No deal found for id '.$id
            );
        }
        return $this->render('codepromo/show.html.twig', ['deal' => $deal]);
    }

    /**
     * @Route("/bons-plans/create", name="app_bonsplans_create")
     */
    public function createBonPlan(Request $request){
        $bonPlan = new Deal();
        $user = $this->getUser();
        if ($user == null){
            return $this->redirect($this->generateUrl('app_login'));
        }
        else{
            $bonPlan->setAuteur($user);
        }

        $bonPlan->setNote(0);
        $date = date("Y-m-d H:i:s");
        $bonPlan->setDatePublication($date);
        $repository = $this->getDoctrine()->getRepository(DealType::class);
        $typeBonPlan = $repository->find(1);
        $bonPlan->setType($typeBonPlan);
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

        return $this->render('bonplan/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
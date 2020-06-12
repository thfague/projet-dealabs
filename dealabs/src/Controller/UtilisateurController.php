<?php

namespace App\Controller;

use App\Entity\Deal;
use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/save/{id}", name="app_save_deal")
     */
    public function saveDeal($id)
    {
        $userI = $this->getUser();
        if ($userI == null) {
            return $this->redirect($this->generateUrl('app_login'));
        } else {
            $deal = $this->getDoctrine()->getRepository(Deal::class)->find($id);
            $user = $this->getDoctrine()->getRepository(Utilisateur::class)->find($userI);
            $deal->addUtilisateursSaved($user);
            $user->addDealsSaved($deal);
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            return $this->redirect($this->generateUrl('app_deals_list'));
        }
    }

    /**
     * @Route("/user", name="app_user_view")
     */
    public function viewUser()
    {
        $userI = $this->getUser();
        if ($userI == null) {
            return $this->redirect($this->generateUrl('app_login'));
        } else {
            $user = $this->getDoctrine()->getRepository(Utilisateur::class)->find($userI);
            return $this->render('user/show.html.twig', ['user' => $user]);
        }
    }

    /**
     * @Route("/user/dealsaved", name="app_deals_saved")
     */
    public function userDealsSaved()
    {
        $userI = $this->getUser();
        if ($userI == null) {
            return $this->redirect($this->generateUrl('app_login'));
        } else {
            $user = $this->getDoctrine()->getRepository(Utilisateur::class)->find($userI);
            return $this->render('user/deal/showsaved.html.twig', ['deals' => $user->getDealsSaved(), 'user' => $user]);
        }
    }

    /**
     * @Route("/user/dealcreated", name="app_deals_created")
     */
    public function userDealsCreated()
    {
        $userI = $this->getUser();
        if ($userI == null) {
            return $this->redirect($this->generateUrl('app_login'));
        } else {
            $deals = $this->getDoctrine()->getRepository(Deal::class)->findDealsByUserId($userI);
            $user = $this->getDoctrine()->getRepository(Utilisateur::class)->find($userI);
            return $this->render('user/deal/showcreated.html.twig', ['deals' => $deals, 'user' => $user]);
        }
    }
}
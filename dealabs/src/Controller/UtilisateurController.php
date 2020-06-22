<?php

namespace App\Controller;

use App\Entity\Deal;
use App\Entity\ParamAlerte;
use App\Entity\Utilisateur;
use App\Form\Type\ParamAlerteType;
use App\Repository\CommentaireRepository;
use App\Repository\DealRepository;
use App\Repository\ParamAlerteRepository;
use App\Repository\UtilisateurRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/user/delete", name="app_user_delete")
     */
    public function deleteUser()
    {
        $userI = $this->getUser();
        if ($userI == null) {
            return $this->redirect($this->generateUrl('app_login'));
        } else {
            $user = $this->getDoctrine()->getRepository(Utilisateur::class)->find($userI);
            $user->setPseudo('Anonyme');
            $user->setEmail('');
            $user->setMdp('');
            $date = new DateTime('@' . strtotime('now'));
            $user->setDeletedAt($date);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirect($this->generateUrl('app_logout'));
        }
    }

    /**
     * @Route("/user/stats", name="app_deals_stats")
     */
    public function getStatistiques(UtilisateurRepository $utilisateurRepository, DealRepository $dealRepository, CommentaireRepository $commentaireRepository){
        $userI = $this->getUser();
        if ($userI == null){
            return $this->redirect($this->generateUrl('app_login'));
        }
        else{
            $user = $utilisateurRepository->find($userI);
            $nbDealsPostes = $dealRepository->getNbDealsPostes($user->getId());
            $nbCommentairesPostes = $commentaireRepository->getNbCommentairesPostes($user->getId());
            $noteDealHot = $dealRepository->getRateHottestDeal($user->getId());
            $moyNote = $dealRepository->getAverageRatesOneYear($user->getId());
            $nbDealsHot = $dealRepository->getHotDeals($user->getId());
            $pourcent = $nbDealsHot/$nbDealsPostes*100;
            return $this->render('user/statistiques.html.twig', [
                'nbDealsPostes' => $nbDealsPostes,
                'nbCommentairesPostes' => $nbCommentairesPostes,
                'noteDealHot' => $noteDealHot,
                'moyNote' => $moyNote,
                'pourcentDealsHot' => $pourcent
            ]);
        }
    }

    /**
     * @Route("/user/gestion-alertes", name="app_gestion_alertes")
     */
    public function gererAlerte(Request $request){
        $paramAlerte = new ParamAlerte();
        $user = $this->getUser();
        if ($user == null){
            return $this->redirect($this->generateUrl('app_login'));
        }
        else{
            $paramAlerte->setUtilisateur($user);
        }

        $form = $this->createForm(ParamAlerteType::class, $paramAlerte);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $paramAlerte = $form->getData();
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($paramAlerte);
            $manager->flush();

            //à changer
            return $this->redirect($this->generateUrl('app_user_view'));
        }

        return $this->render('user/alertes/gestion.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Deal;
use App\Entity\DealType;
use App\Entity\Utilisateur;
use App\Form\Type\BonPlanType;
use App\Form\Type\CodePromoType;
use App\Form\Type\CommentaireType;
use App\Repository\DealRepository;
use App\Repository\UtilisateurRepository;
use DateTime;
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
        $deals = $repository->findAllDeals();
        return $this->render('homepage.html.twig', ['deals' => $deals]);
    }

    /**
     * @Route("/bons-plans", name="app_bonplan_list")
     */
    public function listBonsPlans()
    {
        $repository = $this->getDoctrine()->getRepository(Deal::class);
        $deals = $repository->findAllBonsPlans();
        return $this->render('bonplan/showall.html.twig', ['deals' => $deals]);
    }

    /**
     * @Route("/codes-promo", name="app_codepromo_list")
     */
    public function listCodesPromo()
    {
        $repository = $this->getDoctrine()->getRepository(Deal::class);
        $deals = $repository->findAllCodesPromo();
        return $this->render('codepromo/showall.html.twig', ['deals' => $deals]);
    }

    /**
     * @Route("/bons-plans/{id}", name="app_bonplan_single", requirements={"id"="\d+"})
     */
    public function singleBonPlan(int $id, Request $request)
    {
        $deal = $this->getDoctrine()
            ->getRepository(Deal::class)
            ->findDeal($id);
        if(!$deal) {
            throw $this->createNotFoundException(
                'No deal found for id '.$id
            );
        }
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $commentaire = $form->getData();
            $user = $this->getUser();
            if ($user == null){
                return $this->redirect($this->generateUrl('app_login'));
            }
            else{
                $commentaire->setAuteur($user);
                $commentaire->setDeal($deal);
                $date = new DateTime('@'.strtotime('now'));
                $commentaire->setDatePublication($date);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($commentaire);
                $manager->flush();
                return $this->redirect($this->generateUrl('app_bonplan_single', array('id' => $id)));
            }
        }
        return $this->render('bonplan/show.html.twig', ['deal' => $deal, 'form' => $form->createView()]);
    }

    /**
     * @Route("/codes-promo/{id}", name="app_codepromo_single", requirements={"id"="\d+"})
     */
    public function singleCodePromo(int $id, Request $request)
    {
        $deal = $this->getDoctrine()
            ->getRepository(Deal::class)
            ->find($id);
        if(!$deal) {
            throw $this->createNotFoundException(
                'No deal found for id '.$id
            );
        }
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $commentaire = $form->getData();
            $user = $this->getUser();
            if ($user == null){
                return $this->redirect($this->generateUrl('app_login'));
            }
            else{
                $commentaire->setAuteur($user);
                $commentaire->setDeal($deal);
                $date = new DateTime('@'.strtotime('now'));
                $commentaire->setDatePublication($date);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($commentaire);
                $manager->flush();
                return $this->redirect($this->generateUrl('app_codepromo_single', array('id' => $id)));
            }
        }

        return $this->render('codepromo/show.html.twig', ['deal' => $deal, 'commentaires' => $deal->getCommentaires(), 'form' => $form->createView()]);
    }

    /**
     * @Route("/bons-plans/create", name="app_bonplan_create")
     * @throws \Exception
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
        $date = new DateTime('@'.strtotime('now'));
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

    /**
     * @Route("/codes-promo/create", name="app_codepromo_create")
     * @throws \Exception
     */
    public function createCodePromo(Request $request){
        $codePromo = new Deal();
        $user = $this->getUser();
        if ($user == null){
            return $this->redirect($this->generateUrl('app_login'));
        }
        else{
            $codePromo->setAuteur($user);
        }

        $codePromo->setNote(0);
        $date = new DateTime('@'.strtotime('now'));
        $codePromo->setDatePublication($date);
        $repository = $this->getDoctrine()->getRepository(DealType::class);
        $typeCodePromo = $repository->find(2);
        $codePromo->setType($typeCodePromo);
        $form = $this->createForm(CodePromoType::class, $codePromo);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $codePromo = $form->getData();
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($codePromo);
            $manager->flush();

            //à changer
            return $this->redirect($this->generateUrl('app_deals_list'));
        }

        return $this->render('codepromo/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/note/{dealId}/{valeur}", name="app_note")
     */
    public function noteDeal(int $dealId, int $valeur){
        $user = $this->getUser();
        if ($user == null){
            return $this->redirect($this->generateUrl('app_login'));
        }
        else{
            $repository = $this->getDoctrine()->getRepository(Deal::class);
            $deal = new Deal();
            $deal = $repository->find($dealId);
            $deal->setNote($deal->getNote()+$valeur);
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            return $this->redirect($this->generateUrl('app_deals_list'));
        }

    }

    /**
     * @Route("/signaler/{dealId}", name="app_signaler")
     */
    public function signaler(DealRepository $dealRepository, UtilisateurRepository $utilisateurRepository, int $dealId){
        $user = $this->getUser();
        if ($user == null){
            return $this->redirect($this->generateUrl('app_login'));
        }
        $deal = new Deal();
        $deal = $dealRepository->findDealAndDealTypeById($dealId);
        $admin = new Utilisateur();
        $admin = $utilisateurRepository->getAdmin();
        $transport = (new \Swift_SmtpTransport('localhost', 1025));
        $mailer = new \Swift_Mailer($transport);
        $message = (new \Swift_Message('Signalement deal'))
            ->setFrom($user->getEmail())
            ->setTo($admin->getEmail())
            ->setBody("le deal suivant a été signalé " . $deal->getNom());

        $result = $mailer->send($message);
        $dealType = $deal->getType();
        if ($dealType->getId() == 1) {
            return $this->redirect($this->generateUrl('app_bonplan_single', array('id' => $dealId)));
        } else {
            return $this->redirect($this->generateUrl('app_codepromo_single', array('id' => $dealId)));
        }
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Elsword XIII
 * Date: 23/06/2020
 * Time: 11:19
 */

namespace App\Command;

use App\Entity\Deal;
use App\Entity\ParamAlerte;
use App\Entity\Utilisateur;
use App\Repository\DealRepository;
use App\Repository\ParamAlerteRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Twig\Environment;

class AlerteCommand extends Command
{
    protected static $defaultName = 'app:send-alertes';
    private $entityManager;
    private $twig;

    public function __construct(EntityManagerInterface $entityManager, Environment $twig)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->twig = $twig;
    }

    protected function configure()
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var UtilisateurRepository $utilisateurRepository */
        $utilisateurRepository = $this->entityManager->getRepository(Utilisateur::class);
        /** @var ParamAlerteRepository $paramAlerteRepository */
        $paramAlerteRepository = $this->entityManager->getRepository(ParamAlerte::class);
        /** @var DealRepository $dealRepository */
        $dealRepository = $this->entityManager->getRepository(Deal::class);

        $users = $utilisateurRepository->findAll();
        $admin = $utilisateurRepository->getAdmin();
        foreach ($users as $user){
            $paramAlerte = $paramAlerteRepository->findByUserId($user->getId());
            $motsCles = explode("/", $paramAlerte->getMotsCles());
            $deals = $dealRepository->getDealsByParamAlerte($motsCles, $paramAlerte->getNoteMin());
            if (count($deals) == 0 || !$paramAlerte->getMail()){
                continue;
            }
            $transport = (new \Swift_SmtpTransport('localhost', 1025));
            $mailer = new \Swift_Mailer($transport);
            $message = (new \Swift_Message("[DEALABS] Fil d'alertes"))
                ->setFrom($user->getEmail())
                ->setTo($admin->getEmail())
                ->setBody(
                    $this->twig->render(
                        'email/filAlertes.html.twig', [
                            'deals' => $deals
                        ]
                    ),
                    'text/html'
                );

            $result = $mailer->send($message);
        }

        return 0;
    }
}
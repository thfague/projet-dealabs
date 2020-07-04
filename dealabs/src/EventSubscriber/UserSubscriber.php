<?php

namespace App\EventSubscriber;

use App\Entity\UserBadge;
use App\Event\UserCommentEvent;
use App\Event\UserCreatedDealEvent;
use App\Event\UserVotedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserVotedEvent::class => 'onUserVoted',
            UserCreatedDealEvent::class => 'onUserCreatedDeal',
            UserCommentEvent::class => 'onUserComment'
        ];
    }

    public function onUserVoted(UserVotedEvent $event)
    {
        $user = $event->getUser();
        $deal = $event->getDeal();
        $user->addDealsVote($deal);
        if(count($user->getDealsVote()) >= 10) {
            $surveillant = $this->em->getRepository(UserBadge::class)->find(1);
            $user->addUserBadge($surveillant);
        }
    }

    public function onUserCreatedDeal(UserCreatedDealEvent $event)
    {
        $user = $event->getUser();
        if(count($user->getDealsCreated()) >= 10) {
            $cobaye = $this->em->getRepository(UserBadge::class)->find(2);
            $user->addUserBadge($cobaye);
        }
    }

    public function onUserComment(UserCommentEvent $event)
    {
        $user = $event->getUser();
        $commentaire = $event->getCommentaire();
        $user->addCommentaire($commentaire);
        if(count($user->getCommentaires()) >= 10) {
            $rapport = $this->em->getRepository(UserBadge::class)->find(3);
            $user->addUserBadge($rapport);
        }
    }
}

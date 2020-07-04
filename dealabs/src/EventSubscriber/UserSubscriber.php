<?php

namespace App\EventSubscriber;

use App\Entity\UserBadge;
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
        ];
    }

    public function onUserVoted(UserVotedEvent $event)
    {
        $user = $event->getUser();
        $deal = $event->getDeal();
        $user->addDealsVote($deal);
        if(count($user->getDealsVote()) >= 10) {
            $user->addUserBadge();
        }
    }
}

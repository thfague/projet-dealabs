<?php


namespace App\Event;


use App\Entity\Deal;
use App\Entity\Utilisateur;
use Symfony\Contracts\EventDispatcher\Event;

class UserVotedEvent extends Event
{
    public const NAME = 'user.voted';

    protected $user;
    protected $deal;

    public function __construct(Utilisateur $user, Deal $deal)
    {
        $this->user = $user;
        $this->deal = $deal;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getDeal()
    {
        return $this->deal;
    }
}
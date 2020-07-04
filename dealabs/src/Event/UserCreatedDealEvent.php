<?php


namespace App\Event;


use App\Entity\Deal;
use App\Entity\Utilisateur;
use Symfony\Contracts\EventDispatcher\Event;

class UserCreatedDealEvent extends Event
{
    public const NAME = 'user.created.deal';

    protected $user;

    public function __construct(Utilisateur $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
}
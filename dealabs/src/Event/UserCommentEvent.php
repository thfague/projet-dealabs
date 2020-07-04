<?php


namespace App\Event;


use App\Entity\Commentaire;
use App\Entity\Deal;
use App\Entity\Utilisateur;
use Symfony\Contracts\EventDispatcher\Event;

class UserCommentEvent extends Event
{
    public const NAME = 'user.comment';

    protected $user;
    protected $commentaire;

    public function __construct(Utilisateur $user, Commentaire $commentaire)
    {
        $this->user = $user;
        $this->commentaire = $commentaire;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getCommentaire()
    {
        return $this->commentaire;
    }

}
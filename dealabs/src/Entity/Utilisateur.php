<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
class Utilisateur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="auteur")
     */
    private $commentaires;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mdp;

    /**
     * @ORM\OneToMany(targetEntity=Deal::class, mappedBy="auteur")
     */
    private $dealsCreated;

    /**
     * @ORM\ManyToMany(targetEntity=Deal::class, inversedBy="dealsVote")
     */
    private $dealsVote;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->dealsCreated = new ArrayCollection();
        $this->dealsVote = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setAuteur($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getAuteur() === $this) {
                $commentaire->setAuteur(null);
            }
        }

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    /**
     * @return Collection|Deal[]
     */
    public function getDealsCreated(): Collection
    {
        return $this->dealsCreated;
    }

    public function addDealsCreated(Deal $dealsCreated): self
    {
        if (!$this->dealsCreated->contains($dealsCreated)) {
            $this->dealsCreated[] = $dealsCreated;
            $dealsCreated->setAuteur($this);
        }

        return $this;
    }

    public function removeDealsCreated(Deal $dealsCreated): self
    {
        if ($this->dealsCreated->contains($dealsCreated)) {
            $this->dealsCreated->removeElement($dealsCreated);
            // set the owning side to null (unless already changed)
            if ($dealsCreated->getAuteur() === $this) {
                $dealsCreated->setAuteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Deal[]
     */
    public function getDealsVote(): Collection
    {
        return $this->dealsVote;
    }

    public function addDealsVote(Deal $dealsVote): self
    {
        if (!$this->dealsVote->contains($dealsVote)) {
            $this->dealsVote[] = $dealsVote;
        }

        return $this;
    }

    public function removeDealsVote(Deal $dealsVote): self
    {
        if ($this->dealsVote->contains($dealsVote)) {
            $this->dealsVote->removeElement($dealsVote);
        }

        return $this;
    }
}
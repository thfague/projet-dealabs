<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
class Utilisateur implements UserInterface
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mdp;

    /**
     * @ORM\OneToMany(targetEntity=Deal::class, mappedBy="auteur")
     */
    private $dealsCreated;

    /**
     * @ORM\ManyToMany(targetEntity=Deal::class, inversedBy="dealsVote")
     * @JoinTable(name="utilisateur_deal")
     */
    private $dealsVote;

    /**
     * @ORM\OneToMany(targetEntity=DealRate::class, mappedBy="utilisateur")
     */
    private $dealRates;

    /**
     * @ORM\ManyToMany(targetEntity=Deal::class, inversedBy="utilisateursSaved")
     * @JoinTable(name="utilisateur_dealsaved")
     */
    private $dealsSaved;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $role;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\OneToOne(targetEntity=ParamAlerte::class, mappedBy="utilisateur", cascade={"persist", "remove"})
     */
    private $paramAlerte;

    /**
     * @ORM\ManyToMany(targetEntity=UserBadge::class, mappedBy="utilisateurs")
     */
    private $userBadges;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->dealsCreated = new ArrayCollection();
        $this->dealsVote = new ArrayCollection();
        $this->dealRates = new ArrayCollection();
        $this->dealsSaved = new ArrayCollection();
        $this->userBadges = new ArrayCollection();
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

    /*public function getMdp(): ?string
    {
        return $this->mdp;
    }*/

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

    public function getDealRates(): ?DealRate
    {
        return $this->dealRates;
    }

    public function setDealRates(?DealRate $dealRates): self
    {
        $this->dealRates = $dealRates;

        return $this;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return ['ROLE_USER', 'ROLE_ADMIN'];
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->pseudo;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function addDealRate(DealRate $dealRate): self
    {
        if (!$this->dealRates->contains($dealRate)) {
            $this->dealRates[] = $dealRate;
            $dealRate->setUtilisateur($this);
        }

        return $this;
    }

    public function removeDealRate(DealRate $dealRate): self
    {
        if ($this->dealRates->contains($dealRate)) {
            $this->dealRates->removeElement($dealRate);
            // set the owning side to null (unless already changed)
            if ($dealRate->getUtilisateur() === $this) {
                $dealRate->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string|null The encoded password if any
     */
    public function getPassword()
    {
        return $this->mdp;
    }

    /**
     * @return Collection|Deal[]
     */
    public function getDealsSaved(): Collection
    {
        return $this->dealsSaved;
    }

    public function addDealsSaved(Deal $dealsSaved): self
    {
        if (!$this->dealsSaved->contains($dealsSaved)) {
            $this->dealsSaved[] = $dealsSaved;
        }

        return $this;
    }

    public function removeDealsSaved(Deal $dealsSaved): self
    {
        if ($this->dealsSaved->contains($dealsSaved)) {
            $this->dealsSaved->removeElement($dealsSaved);
        }

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getParamAlerte(): ?ParamAlerte
    {
        return $this->paramAlerte;
    }

    public function setParamAlerte(?ParamAlerte $paramAlerte): self
    {
        $this->paramAlerte = $paramAlerte;

        // set (or unset) the owning side of the relation if necessary
        $newUtilisateur = null === $paramAlerte ? null : $this;
        if ($paramAlerte->getUtilisateur() !== $newUtilisateur) {
            $paramAlerte->setUtilisateur($newUtilisateur);
        }

        return $this;
    }

    /**
     * @return Collection|UserBadge[]
     */
    public function getUserBadges(): Collection
    {
        return $this->userBadges;
    }

    public function addUserBadge(UserBadge $userBadge): self
    {
        if (!$this->userBadges->contains($userBadge)) {
            $this->userBadges[] = $userBadge;
            $userBadge->addUtilisateur($this);
        }

        return $this;
    }

    public function removeUserBadge(UserBadge $userBadge): self
    {
        if ($this->userBadges->contains($userBadge)) {
            $this->userBadges->removeElement($userBadge);
            $userBadge->removeUtilisateur($this);
        }

        return $this;
    }
}

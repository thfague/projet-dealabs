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
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="auteur")
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity=DealRate::class, mappedBy="utilisateur")
     */
    private $dealRates;

    /**
     * @ORM\OneToMany(targetEntity=CodePromo::class, mappedBy="auteur")
     */
    private $codePromos;

    /**
     * @ORM\OneToMany(targetEntity=BonPlan::class, mappedBy="auteur")
     */
    private $bonPlans;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->dealRates = new ArrayCollection();
        $this->codePromos = new ArrayCollection();
        $this->bonPlans = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|DealRate[]
     */
    public function getDealRates(): Collection
    {
        return $this->dealRates;
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
     * @return Collection|CodePromo[]
     */
    public function getCodePromos(): Collection
    {
        return $this->codePromos;
    }

    public function addCodePromo(CodePromo $codePromo): self
    {
        if (!$this->codePromos->contains($codePromo)) {
            $this->codePromos[] = $codePromo;
            $codePromo->setAuteur($this);
        }

        return $this;
    }

    public function removeCodePromo(CodePromo $codePromo): self
    {
        if ($this->codePromos->contains($codePromo)) {
            $this->codePromos->removeElement($codePromo);
            // set the owning side to null (unless already changed)
            if ($codePromo->getAuteur() === $this) {
                $codePromo->setAuteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BonPlan[]
     */
    public function getBonPlans(): Collection
    {
        return $this->bonPlans;
    }

    public function addBonPlan(BonPlan $bonPlan): self
    {
        if (!$this->bonPlans->contains($bonPlan)) {
            $this->bonPlans[] = $bonPlan;
            $bonPlan->setAuteur($this);
        }

        return $this;
    }

    public function removeBonPlan(BonPlan $bonPlan): self
    {
        if ($this->bonPlans->contains($bonPlan)) {
            $this->bonPlans->removeElement($bonPlan);
            // set the owning side to null (unless already changed)
            if ($bonPlan->getAuteur() === $this) {
                $bonPlan->setAuteur(null);
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
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
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
        return ['ROLE_USER'];
    }
}

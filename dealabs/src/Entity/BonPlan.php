<?php

namespace App\Entity;

use App\Repository\BonPlanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BonPlanRepository::class)
 */
class BonPlan
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
    private $lien;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="float")
     */
    private $prixHab;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $fdp;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $livraisonGratuite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $valeur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Categorie::class, inversedBy="bonPlans")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=DealRate::class, mappedBy="bonPlan")
     */
    private $dealRates;

    /**
     * @ORM\Column(type="date")
     */
    private $datePublication;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="bonPlans")
     */
    private $auteur;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->dealRates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(string $lien): self
    {
        $this->lien = $lien;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPrixHab(): ?float
    {
        return $this->prixHab;
    }

    public function setPrixHab(float $prixHab): self
    {
        $this->prixHab = $prixHab;

        return $this;
    }

    public function getFdp(): ?float
    {
        return $this->fdp;
    }

    public function setFdp(?float $fdp): self
    {
        $this->fdp = $fdp;

        return $this;
    }

    public function getLivraisonGratuite(): ?bool
    {
        return $this->livraisonGratuite;
    }

    public function setLivraisonGratuite(?bool $livraisonGratuite): self
    {
        $this->livraisonGratuite = $livraisonGratuite;

        return $this;
    }

    public function getValeur(): ?string
    {
        return $this->valeur;
    }

    public function setValeur(?string $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Categorie[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
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
            $dealRate->setBonPlan($this);
        }

        return $this;
    }

    public function removeDealRate(DealRate $dealRate): self
    {
        if ($this->dealRates->contains($dealRate)) {
            $this->dealRates->removeElement($dealRate);
            // set the owning side to null (unless already changed)
            if ($dealRate->getBonPlan() === $this) {
                $dealRate->setBonPlan(null);
            }
        }

        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->datePublication;
    }

    public function setDatePublication(\DateTimeInterface $datePublication): self
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    public function getAuteur(): ?Utilisateur
    {
        return $this->auteur;
    }

    public function setAuteur(?Utilisateur $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }
}

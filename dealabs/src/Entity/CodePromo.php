<?php

namespace App\Entity;

use App\Repository\CodePromoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CodePromoRepository::class)
 */
class CodePromo
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $typeReduction;

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
     * @ORM\Column(type="float", nullable=true)
     */
    private $valeurReduc;

    /**
     * @ORM\ManyToMany(targetEntity=Categorie::class, mappedBy="codePromos")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=DealRate::class, mappedBy="codePromo")
     */
    private $dealRates;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $datePublication;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="codePromos")
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

    public function getTypeReduction(): ?int
    {
        return $this->typeReduction;
    }

    public function setTypeReduction(?int $typeReduction): self
    {
        $this->typeReduction = $typeReduction;

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

    public function getValeurReduc(): ?float
    {
        return $this->valeurReduc;
    }

    public function setValeurReduc(?float $valeurReduc): self
    {
        $this->valeurReduc = $valeurReduc;

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
            $category->addCodePromo($this);
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            $category->removeCodePromo($this);
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
            $dealRate->setCodePromo($this);
        }

        return $this;
    }

    public function removeDealRate(DealRate $dealRate): self
    {
        if ($this->dealRates->contains($dealRate)) {
            $this->dealRates->removeElement($dealRate);
            // set the owning side to null (unless already changed)
            if ($dealRate->getCodePromo() === $this) {
                $dealRate->setCodePromo(null);
            }
        }

        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->datePublication;
    }

    public function setDatePublication(?\DateTimeInterface $datePublication): self
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

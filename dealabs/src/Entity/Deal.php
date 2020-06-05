<?php

namespace App\Entity;

use App\Repository\DealRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DealRepository::class)
 */
class Deal
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Categorie::class, mappedBy="deals")
     */
    private $categories;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="float")
     */
    private $fdp;

    /**
     * @ORM\Column(type="boolean")
     */
    private $livraison;

    /**
     * @ORM\Column(type="float")
     */
    private $prixHab;

    /**
     * @ORM\Column(type="integer")
     */
    private $note;

    /**
     * @ORM\Column(type="date")
     */
    private $datePublication;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="dealsCreated")
     * @ORM\JoinColumn(nullable=false)
     */
    private $auteur;

    /**
     * @ORM\ManyToOne(targetEntity=DealType::class, inversedBy="deals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity=Utilisateur::class, mappedBy="dealsVote")
     */
    private $dealsVote;

    /**
     * @ORM\OneToMany(targetEntity=DealRate::class, mappedBy="deal")
     */
    private $dealRates;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lien;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $typeReduc;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $valeurCodePromo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codePromo;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->dealsVote = new ArrayCollection();
        $this->dealRates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $category->setDeals($this);
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            // set the owning side to null (unless already changed)
            if ($category->getDeals() === $this) {
                $category->setDeals(null);
            }
        }

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

    public function getFdp(): ?float
    {
        return $this->fdp;
    }

    public function setFdp(float $fdp): self
    {
        $this->fdp = $fdp;

        return $this;
    }

    public function getLivraison(): ?bool
    {
        return $this->livraison;
    }

    public function setLivraison(bool $livraison): self
    {
        $this->livraison = $livraison;

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

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getType(): ?DealType
    {
        return $this->type;
    }

    public function setType(?DealType $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getDealsVote(): Collection
    {
        return $this->dealsVote;
    }

    public function addDealsVote(Utilisateur $dealsVote): self
    {
        if (!$this->dealsVote->contains($dealsVote)) {
            $this->dealsVote[] = $dealsVote;
            $dealsVote->addDealsVote($this);
        }

        return $this;
    }

    public function removeDealsVote(Utilisateur $dealsVote): self
    {
        if ($this->dealsVote->contains($dealsVote)) {
            $this->dealsVote->removeElement($dealsVote);
            $dealsVote->removeDealsVote($this);
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

    public function addDealRate(DealRate $dealRate): self
    {
        if (!$this->dealRates->contains($dealRate)) {
            $this->dealRates[] = $dealRate;
            $dealRate->setDeal($this);
        }

        return $this;
    }

    public function removeDealRate(DealRate $dealRate): self
    {
        if ($this->dealRates->contains($dealRate)) {
            $this->dealRates->removeElement($dealRate);
            // set the owning side to null (unless already changed)
            if ($dealRate->getDeal() === $this) {
                $dealRate->setDeal(null);
            }
        }

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(?string $lien): self
    {
        $this->lien = $lien;

        return $this;
    }

    public function getTypeReduc(): ?int
    {
        return $this->typeReduc;
    }

    public function setTypeReduc(?int $typeReduc): self
    {
        $this->typeReduc = $typeReduc;

        return $this;
    }

    public function getValeurCodePromo(): ?float
    {
        return $this->valeurCodePromo;
    }

    public function setValeurCodePromo(?float $valeurCodePromo): self
    {
        $this->valeurCodePromo = $valeurCodePromo;

        return $this;
    }

    public function getCodePromo(): ?string
    {
        return $this->codePromo;
    }

    public function setCodePromo(?string $codePromo): self
    {
        $this->codePromo = $codePromo;

        return $this;
    }
}

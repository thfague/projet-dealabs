<?php

namespace App\Entity;

use App\Repository\DealRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;

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
     * @ORM\Column(type="float", nullable=true)
     */
    private $prix;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $fdp;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $livraison;

    /**
     * @ORM\Column(type="float", nullable=true)
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
     * @ORM\Column(type="string", length=1000, nullable=true)
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

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="deals")
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="deal")
     */
    private $commentaires;

    /**
     * @ORM\ManyToMany(targetEntity=Utilisateur::class, mappedBy="dealsSaved")
     */
    private $utilisateursSaved;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->dealsVote = new ArrayCollection();
        $this->dealRates = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->utilisateursSaved = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

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
            $commentaire->setDeal($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getDeal() === $this) {
                $commentaire->setDeal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getUtilisateursSaved(): Collection
    {
        return $this->utilisateursSaved;
    }

    public function addUtilisateursSaved(Utilisateur $utilisateursSaved): self
    {
        if (!$this->utilisateursSaved->contains($utilisateursSaved)) {
            $this->utilisateursSaved[] = $utilisateursSaved;
            $utilisateursSaved->addDealsSaved($this);
        }

        return $this;
    }

    public function removeUtilisateursSaved(Utilisateur $utilisateursSaved): self
    {
        if ($this->utilisateursSaved->contains($utilisateursSaved)) {
            $this->utilisateursSaved->removeElement($utilisateursSaved);
            $utilisateursSaved->removeDealsSaved($this);
        }

        return $this;
    }
}

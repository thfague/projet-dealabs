<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
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
    private $nom;

    /**
     * @ORM\ManyToMany(targetEntity=CodePromo::class, inversedBy="categories")
     */
    private $codePromos;

    /**
     * @ORM\ManyToMany(targetEntity=BonPlan::class, mappedBy="categories")
     */
    private $bonPlans;

    public function __construct()
    {
        $this->codePromos = new ArrayCollection();
        $this->bonPlans = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
        }

        return $this;
    }

    public function removeCodePromo(CodePromo $codePromo): self
    {
        if ($this->codePromos->contains($codePromo)) {
            $this->codePromos->removeElement($codePromo);
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
            $bonPlan->addCategory($this);
        }

        return $this;
    }

    public function removeBonPlan(BonPlan $bonPlan): self
    {
        if ($this->bonPlans->contains($bonPlan)) {
            $this->bonPlans->removeElement($bonPlan);
            $bonPlan->removeCategory($this);
        }

        return $this;
    }
}

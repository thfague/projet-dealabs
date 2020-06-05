<?php

namespace App\Entity;

use App\Repository\DealRateRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DealRateRepository::class)
 */
class DealRate
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rate;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="dealRates")
     */
    private $utilisateur;

    /**
     * @ORM\ManyToOne(targetEntity=CodePromo::class, inversedBy="dealRates")
     */
    private $codePromo;

    /**
     * @ORM\ManyToOne(targetEntity=BonPlan::class, inversedBy="dealRates")
     */
    private $bonPlan;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(?int $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getCodePromo(): ?CodePromo
    {
        return $this->codePromo;
    }

    public function setCodePromo(?CodePromo $codePromo): self
    {
        $this->codePromo = $codePromo;

        return $this;
    }

    public function getBonPlan(): ?BonPlan
    {
        return $this->bonPlan;
    }

    public function setBonPlan(?BonPlan $bonPlan): self
    {
        $this->bonPlan = $bonPlan;

        return $this;
    }
}

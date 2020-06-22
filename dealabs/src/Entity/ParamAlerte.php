<?php

namespace App\Entity;

use App\Repository\ParamAlerteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParamAlerteRepository::class)
 */
class ParamAlerte
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $motsCles;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $noteMin;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $mail;

    /**
     * @ORM\OneToOne(targetEntity=Utilisateur::class, inversedBy="paramAlerte", cascade={"persist", "remove"})
     */
    private $utilisateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMotsCles(): ?string
    {
        return $this->motsCles;
    }

    public function setMotsCles(?string $motsCles): self
    {
        $this->motsCles = $motsCles;

        return $this;
    }

    public function getNoteMin(): ?int
    {
        return $this->noteMin;
    }

    public function setNoteMin(?int $noteMin): self
    {
        $this->noteMin = $noteMin;

        return $this;
    }

    public function getMail(): ?bool
    {
        return $this->mail;
    }

    public function setMail(?bool $mail): self
    {
        $this->mail = $mail;

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
}

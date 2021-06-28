<?php

namespace App\Entity;

use App\Repository\OrsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrsRepository::class)
 */
class Ors
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $kilometrage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $traveauDemande;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $observation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $garantie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $campagne;

    /**
     * @ORM\ManyToOne(targetEntity=Clients::class, inversedBy="ors")
     */
    private $client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKilo9metrage(): ?int
    {
        return $this->kilometrage;
    }

    public function setKilo9metrage(int $kilometrage): self
    {
        $this->kilometrage = $kilometrage;

        return $this;
    }

    public function getTraveauDemande(): ?string
    {
        return $this->traveauDemande;
    }

    public function setTraveauDemande(string $traveauDemande): self
    {
        $this->traveauDemande = $traveauDemande;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(string $observation): self
    {
        $this->observation = $observation;

        return $this;
    }

    public function getGarantie(): ?bool
    {
        return $this->garantie;
    }

    public function setGarantie(bool $garantie): self
    {
        $this->garantie = $garantie;

        return $this;
    }

    public function getCampagne(): ?string
    {
        return $this->campagne;
    }

    public function setCampagne(string $campagne): self
    {
        $this->campagne = $campagne;

        return $this;
    }

    public function getPiece()
    {
        return $this->piece;
    }

    public function setPiece($piece): self
    {
        $this->piece = $piece;

        return $this;
    }

    public function getClient(): ?Clients
    {
        return $this->client;
    }

    public function setClient(?Clients $client): self
    {
        $this->client = $client;

        return $this;
    }
}

<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\VehiculesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VehiculesRepository::class)
 */
#[ApiResource]
class Vehicules
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Clients::class, inversedBy="vehicules")
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=Marques::class, inversedBy="vehicules")
     */
    private $marque;

    /**
     * @ORM\ManyToOne(targetEntity=ModeleVehicule::class, inversedBy="vehicules")
     */
    private $modele;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $immatriculation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $chassis;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numeroMoteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numeroBC;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dmc;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMarque(): ?Marques
    {
        return $this->marque;
    }

    public function setMarque(?Marques $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModele(): ?ModeleVehicule
    {
        return $this->modele;
    }

    public function setModele(?ModeleVehicule $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): self
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getChassis(): ?string
    {
        return $this->chassis;
    }

    public function setChassis(string $chassis): self
    {
        $this->chassis = $chassis;

        return $this;
    }

    public function getNumeroMoteur(): ?string
    {
        return $this->numeroMoteur;
    }

    public function setNumeroMoteur(string $numeroMoteur): self
    {
        $this->numeroMoteur = $numeroMoteur;

        return $this;
    }

    public function getNumeroBC(): ?string
    {
        return $this->numeroBC;
    }

    public function setNumeroBC(string $numeroBC): self
    {
        $this->numeroBC = $numeroBC;

        return $this;
    }

    public function getDmc(): ?\DateTimeInterface
    {
        return $this->dmc;
    }

    public function setDmc(\DateTimeInterface $dmc): self
    {
        $this->dmc = $dmc;

        return $this;
    }
}

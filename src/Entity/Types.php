<?php

namespace App\Entity;

use App\Repository\TypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypesRepository::class)
 */
class Types
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Clients::class, mappedBy="type")
     */
    private $clients;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Fourniseurs::class, mappedBy="type")
     */
    private $fourniseurs;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
        $this->fourniseurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Clients[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Clients $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->setType($this);
        }

        return $this;
    }

    public function removeClient(Clients $client): self
    {
        if ($this->clients->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getType() === $this) {
                $client->setType(null);
            }
        }

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|Fourniseurs[]
     */
    public function getFourniseurs(): Collection
    {
        return $this->fourniseurs;
    }

    public function addFourniseur(Fourniseurs $fourniseur): self
    {
        if (!$this->fourniseurs->contains($fourniseur)) {
            $this->fourniseurs[] = $fourniseur;
            $fourniseur->setType($this);
        }

        return $this;
    }

    public function removeFourniseur(Fourniseurs $fourniseur): self
    {
        if ($this->fourniseurs->removeElement($fourniseur)) {
            // set the owning side to null (unless already changed)
            if ($fourniseur->getType() === $this) {
                $fourniseur->setType(null);
            }
        }

        return $this;
    }
}

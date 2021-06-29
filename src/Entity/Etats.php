<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EtatsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtatsRepository::class)
 */
#[ApiResource]
class Etats
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Ors::class, mappedBy="etat")
     */
    private $ors;

    public function __construct()
    {
        $this->ors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|Ors[]
     */
    public function getOrs(): Collection
    {
        return $this->ors;
    }

    public function addOr(Ors $or): self
    {
        if (!$this->ors->contains($or)) {
            $this->ors[] = $or;
            $or->setEtat($this);
        }

        return $this;
    }

    public function removeOr(Ors $or): self
    {
        if ($this->ors->removeElement($or)) {
            // set the owning side to null (unless already changed)
            if ($or->getEtat() === $this) {
                $or->setEtat(null);
            }
        }

        return $this;
    }
}

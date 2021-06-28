<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MarquesRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MarquesRepository::class)
 */
class Marques
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups ({"vehicule:read"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=ModeleVehicule::class, mappedBy="marque")
     */
    private $modeleVehicules;

    /**
     * @ORM\OneToMany(targetEntity=Vehicules::class, mappedBy="marque")
     */
    private $vehicules;

    public function __construct()
    {
        $this->modeleVehicules = new ArrayCollection();
        $this->vehicules = new ArrayCollection();
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
     * @return Collection|ModeleVehicule[]
     */
    public function getModeleVehicules(): Collection
    {
        return $this->modeleVehicules;
    }

    public function addModeleVehicule(ModeleVehicule $modeleVehicule): self
    {
        if (!$this->modeleVehicules->contains($modeleVehicule)) {
            $this->modeleVehicules[] = $modeleVehicule;
            $modeleVehicule->setMarque($this);
        }

        return $this;
    }

    public function removeModeleVehicule(ModeleVehicule $modeleVehicule): self
    {
        if ($this->modeleVehicules->removeElement($modeleVehicule)) {
            // set the owning side to null (unless already changed)
            if ($modeleVehicule->getMarque() === $this) {
                $modeleVehicule->setMarque(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Vehicules[]
     */
    public function getVehicules(): Collection
    {
        return $this->vehicules;
    }

    public function addVehicule(Vehicules $vehicule): self
    {
        if (!$this->vehicules->contains($vehicule)) {
            $this->vehicules[] = $vehicule;
            $vehicule->setMarque($this);
        }

        return $this;
    }

    public function removeVehicule(Vehicules $vehicule): self
    {
        if ($this->vehicules->removeElement($vehicule)) {
            // set the owning side to null (unless already changed)
            if ($vehicule->getMarque() === $this) {
                $vehicule->setMarque(null);
            }
        }

        return $this;
    }
}

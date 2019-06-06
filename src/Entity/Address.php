<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AddressRepository")
 */
class Address
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
    private $Street;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $City;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $State;

    /**
     * @ORM\Column(type="integer")
     */
    private $Zip;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Hospital", mappedBy="Address")
     */
    private $Hospitals;

    public function __construct()
    {
        $this->Hospitals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet(): ?string
    {
        return $this->Street;
    }

    public function setStreet(string $Street): self
    {
        $this->Street = $Street;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->City;
    }

    public function setCity(string $City): self
    {
        $this->City = $City;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->State;
    }

    public function setState(string $State): self
    {
        $this->State = $State;

        return $this;
    }

    public function getZip(): ?int
    {
        return $this->Zip;
    }

    public function setZip(int $Zip): self
    {
        $this->Zip = $Zip;

        return $this;
    }

    /**
     * @return Collection|Hospital[]
     */
    public function getHospitals(): Collection
    {
        return $this->Hospitals;
    }

    public function addHospital(Hospital $hospital): self
    {
        if (!$this->Hospitals->contains($hospital)) {
            $this->Hospitals[] = $hospital;
            $hospital->setAddress($this);
        }

        return $this;
    }

    public function removeHospital(Hospital $hospital): self
    {
        if ($this->Hospitals->contains($hospital)) {
            $this->Hospitals->removeElement($hospital);
            // set the owning side to null (unless already changed)
            if ($hospital->getAddress() === $this) {
                $hospital->setAddress(null);
            }
        }

        return $this;
    }
}

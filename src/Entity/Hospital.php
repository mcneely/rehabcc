<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HospitalRepository")
 */
class Hospital
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
    private $Name;

    /**
     * @ORM\Column(type="string", length=12, nullable=true)
     */
    private $Phone;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Address", inversedBy="Hospitals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Address;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contact", mappedBy="Hospital", orphanRemoval=true)
     */
    private $Contacts;

    public function __construct()
    {
        $this->Contacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->Phone;
    }

    public function setPhone(?string $Phone): self
    {
        $this->Phone = $Phone;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->Address;
    }

    public function setAddress(?Address $Address): self
    {
        $this->Address = $Address;

        return $this;
    }

    /**
     * @return Collection|Contact[]
     */
    public function getContacts(): Collection
    {
        return $this->Contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->Contacts->contains($contact)) {
            $this->Contacts[] = $contact;
            $contact->setHospital($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->Contacts->contains($contact)) {
            $this->Contacts->removeElement($contact);
            // set the owning side to null (unless already changed)
            if ($contact->getHospital() === $this) {
                $contact->setHospital(null);
            }
        }

        return $this;
    }
}

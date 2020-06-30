<?php

namespace App\Entity;

use App\Repository\UnitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UnitRepository::class)
 */
class Unit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $unit;

    /**
     * @ORM\OneToMany(targetEntity=Quantity::class, mappedBy="unit")
     */
    private $quantity;

    public function __construct()
    {
        $this->quantity = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * @return Collection|Quantity[]
     */
    public function getQuantity(): Collection
    {
        return $this->quantity;
    }

    public function addQuantity(Quantity $quantity): self
    {
        if (!$this->quantity->contains($quantity)) {
            $this->quantity[] = $quantity;
            $quantity->setUnit($this);
        }

        return $this;
    }

    public function removeQuantity(Quantity $quantity): self
    {
        if ($this->quantity->contains($quantity)) {
            $this->quantity->removeElement($quantity);
            // set the owning side to null (unless already changed)
            if ($quantity->getUnit() === $this) {
                $quantity->setUnit(null);
            }
        }

        return $this;
    }
}

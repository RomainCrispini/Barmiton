<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=IngredientRepository::class)
 * @ApiResource(
 *  normalizationContext={"groups"={"read:ingredient"}},
 *  collectionOperations={"get", "post"},
 *  itemOperations={"get"})
 */
class Ingredient
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read:ingredient"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"read:ingredient"})
     */
    private $ingredientName;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read:ingredient"})
     */
    private $ingredientIsValid;

    /**
     * @ORM\OneToMany(targetEntity=Quantity::class, mappedBy="ingredient")
     * @Groups({"read:ingredient"})
     */
    private $quantities;

    public function __construct()
    {
        $this->quantities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIngredientName(): ?string
    {
        return $this->ingredientName;
    }

    public function setIngredientName(string $ingredientName): self
    {
        $this->ingredientName = $ingredientName;

        return $this;
    }

    public function getIngredientIsValid(): ?bool
    {
        return $this->ingredientIsValid;
    }

    public function setIngredientIsValid(bool $ingredientIsValid): self
    {
        $this->ingredientIsValid = $ingredientIsValid;

        return $this;
    }

    /**
     * @return Collection|Quantity[]
     */
    public function getQuantities(): Collection
    {
        return $this->quantities;
    }

    public function addQuantity(Quantity $quantity): self
    {
        if (!$this->quantities->contains($quantity)) {
            $this->quantities[] = $quantity;
            $quantity->setIngredient($this);
        }

        return $this;
    }

    public function removeQuantity(Quantity $quantity): self
    {
        if ($this->quantities->contains($quantity)) {
            $this->quantities->removeElement($quantity);
            // set the owning side to null (unless already changed)
            if ($quantity->getIngredient() === $this) {
                $quantity->setIngredient(null);
            }
        }

        return $this;
    }
}

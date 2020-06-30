<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ElementRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *  normalizationContext={"groups"={"read:element"}},
 *  collectionOperations={"get", "post"},
 *  itemOperations={"get"})
 * @ORM\Entity(repositoryClass=ElementRepository::class)
 */
class Element
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read:element"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"read:element"})
     */
    private $unit;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"read:element"})
     */
    private $quantity;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:element"})
     */
    private $ingredient;

    /**
     * @ORM\ManyToOne(targetEntity=recipe::class, inversedBy="elements")
     * @Groups({"read:element"})
     */
    private $recipe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(?string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(?float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getIngredient(): ?string
    {
        return $this->ingredient;
    }

    public function setIngredient(string $ingredient): self
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    public function getRecipe(): ?recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?recipe $recipe): self
    {
        $this->recipe = $recipe;

        return $this;
    }
}

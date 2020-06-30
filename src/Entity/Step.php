<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\StepRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=StepRepository::class)
 *  @ApiResource(
 *  normalizationContext={"groups"={"read:step"}},
 *  collectionOperations={"get", "post"},
 *  itemOperations={"get"})
 */
class Step
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read:step"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"read:step"})
     */
    private $stepNum;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:step"})
     */
    private $stepText;

    /**
     * @ORM\ManyToOne(targetEntity=Recipe::class, inversedBy="steps")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read:step"})
     */
    private $recipe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStepNum(): ?int
    {
        return $this->stepNum;
    }

    public function setStepNum(int $stepNum): self
    {
        $this->stepNum = $stepNum;

        return $this;
    }

    public function getStepText(): ?string
    {
        return $this->stepText;
    }

    public function setStepText(string $stepText): self
    {
        $this->stepText = $stepText;

        return $this;
    }

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipe $recipe): self
    {
        $this->recipe = $recipe;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Entity\Rate;
use App\Entity\Step;
use App\Entity\User;
use App\Entity\Comment;
use App\Entity\Picture;
use App\Entity\Category;
use App\Entity\Quantity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *  normalizationContext={"groups"={"read:Recipe"}},
 *  collectionOperations={"get", "post"},
 *  itemOperations={"get"})
 *  @ORM\Entity(repositoryClass=RecipeRepository::class)
 */
class Recipe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read:Recipe"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"read:Recipe"})
     */
    private $recipeName;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"read:Recipe"})
     */
    private $personNum;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read:Recipe"})
     */
    private $recipeIsValid;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read:Recipe"})
     */
    private $recipeCreatedAt;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"read:Recipe"})
     */
    private $recipeRate;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="recipes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read:Recipe"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="recipe", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=Rate::class, mappedBy="recipe", orphanRemoval=true)
     */
    private $rates;

    /**
     * @ORM\OneToMany(targetEntity=Quantity::class, mappedBy="recipe")
     */
    private $quantities;

    /**
     * @ORM\OneToMany(targetEntity=Picture::class, mappedBy="recipe")
     */
    private $pictures;

    /**
     * @ORM\OneToMany(targetEntity=Step::class, mappedBy="recipe", orphanRemoval=true)
     */
    private $steps;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="recipes")
     * @ApiSubresource
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=Element::class, mappedBy="recipe")
     */
    private $elements;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->rates = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->quantities = new ArrayCollection();
        $this->pictures = new ArrayCollection();
        $this->steps = new ArrayCollection();
        $this->elements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecipeName(): ?string
    {
        return $this->recipeName;
    }

    public function setRecipeName(string $recipeName): self
    {
        $this->recipeName = $recipeName;

        return $this;
    }

    public function getPersonNum(): ?int
    {
        return $this->personNum;
    }

    public function setPersonNum(int $personNum): self
    {
        $this->personNum = $personNum;

        return $this;
    }

    public function getRecipeIsValid(): ?bool
    {
        return $this->recipeIsValid;
    }

    public function setRecipeIsValid(bool $recipeIsValid): self
    {
        $this->recipeIsValid = $recipeIsValid;

        return $this;
    }

    public function getRecipeCreatedAt(): ?\DateTimeInterface
    {
        return $this->recipeCreatedAt;
    }

    public function setRecipeCreatedAt(\DateTimeInterface $recipeCreatedAt): self
    {
        $this->recipeCreatedAt = $recipeCreatedAt;

        return $this;
    }

    public function getRecipeRate(): ?float
    {
        return $this->recipeRate;
    }

    public function setRecipeRate(?float $recipeRate): self
    {
        $this->recipeRate = $recipeRate;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setRecipe($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getRecipe() === $this) {
                $comment->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Rate[]
     */
    public function getRates(): Collection
    {
        return $this->rates;
    }

    public function addRate(Rate $rate): self
    {
        if (!$this->rates->contains($rate)) {
            $this->rates[] = $rate;
            $rate->setRecipe($this);
        }

        return $this;
    }

    public function removeRate(Rate $rate): self
    {
        if ($this->rates->contains($rate)) {
            $this->rates->removeElement($rate);
            // set the owning side to null (unless already changed)
            if ($rate->getRecipe() === $this) {
                $rate->setRecipe(null);
            }
        }

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
            $quantity->setRecipe($this);
        }

        return $this;
    }

    public function removeQuantity(Quantity $quantity): self
    {
        if ($this->quantities->contains($quantity)) {
            $this->quantities->removeElement($quantity);
            // set the owning side to null (unless already changed)
            if ($quantity->getRecipe() === $this) {
                $quantity->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Picture[]
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setRecipe($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->contains($picture)) {
            $this->pictures->removeElement($picture);
            // set the owning side to null (unless already changed)
            if ($picture->getRecipe() === $this) {
                $picture->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Step[]
     */
    public function getSteps(): Collection
    {
        return $this->steps;
    }

    public function addStep(Step $step): self
    {
        if (!$this->steps->contains($step)) {
            $this->steps[] = $step;
            $step->setRecipe($this);
        }

        return $this;
    }

    public function removeStep(Step $step): self
    {
        if ($this->steps->contains($step)) {
            $this->steps->removeElement($step);
            // set the owning side to null (unless already changed)
            if ($step->getRecipe() === $this) {
                $step->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }

    /**
     * @return Collection|Element[]
     */
    public function getElements(): Collection
    {
        return $this->elements;
    }

    public function addElement(Element $element): self
    {
        if (!$this->elements->contains($element)) {
            $this->elements[] = $element;
            $element->setRecipe($this);
        }

        return $this;
    }

    public function removeElement(Element $element): self
    {
        if ($this->elements->contains($element)) {
            $this->elements->removeElement($element);
            // set the owning side to null (unless already changed)
            if ($element->getRecipe() === $this) {
                $element->setRecipe(null);
            }
        }

        return $this;
    }
}

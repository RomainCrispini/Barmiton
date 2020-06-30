<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $commentCreatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $commentText;

    /**
     * @ORM\Column(type="boolean")
     */
    private $commentIsValid;

    /**
     * @ORM\ManyToOne(targetEntity=Recipe::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $recipe;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentCreatedAt(): ?\DateTimeInterface
    {
        return $this->commentCreatedAt;
    }

    public function setCommentCreatedAt(\DateTimeInterface $commentCreatedAt): self
    {
        $this->commentCreatedAt = $commentCreatedAt;

        return $this;
    }

    public function getCommentText(): ?string
    {
        return $this->commentText;
    }

    public function setCommentText(string $commentText): self
    {
        $this->commentText = $commentText;

        return $this;
    }

    public function getCommentIsValid(): ?bool
    {
        return $this->commentIsValid;
    }

    public function setCommentIsValid(bool $commentIsValid): self
    {
        $this->commentIsValid = $commentIsValid;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\Timestampable;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 *
 * @ORM\HasLifecycleCallbacks
 */
class Comment
{
    /*
     * Timestampable trait
     */
    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Comment::class, inversedBy="comments")
     */
    private $parent_comment;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="parent_comment")
     */
    private $comments;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity=Task::class, inversedBy="comments")
     */
    private $task;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->content;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParentComment(): ?self
    {
        return $this->parent_comment;
    }

    public function setParentComment(?self $parent_comment): self
    {
        $this->parent_comment = $parent_comment;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(self $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setParentComment($this);
        }

        return $this;
    }

    public function removeComment(self $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getParentComment() === $this) {
                $comment->setParentComment(null);
            }
        }

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getTask(): ?Task
    {
        return $this->task;
    }

    public function setTask(?Task $task): self
    {
        $this->task = $task;

        return $this;
    }
}

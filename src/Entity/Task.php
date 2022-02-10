<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\Timestampable;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 *
 * @ORM\HasLifecycleCallbacks
 */
class Task
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
     * @ORM\Column(type="string", length=255)
     */
    private ?string $title;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $description;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tasks")
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity=File::class, inversedBy="tasks")
     */
    private $files;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="tasks")
     */
    private $members;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class, inversedBy="tasks")
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="task")
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="tickets")
     */
    private $project;

    /**
     * @ORM\OneToMany(targetEntity=Timework::class, mappedBy="ticket")
     */
    private $timeworks;

    public function __construct()
    {
        $this->files = new ArrayCollection();
        $this->members = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->timeworks = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    /**
     * @return Collection|File[]
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(File $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files[] = $file;
        }

        return $this;
    }

    public function removeFile(File $file): self
    {
        $this->files->removeElement($file);

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(User $member): self
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
        }

        return $this;
    }

    public function removeMember(User $member): self
    {
        $this->members->removeElement($member);

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

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
            $comment->setTask($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTask() === $this) {
                $comment->setTask(null);
            }
        }

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @return Collection|Timework[]
     */
    public function getTimeworks(): Collection
    {
        return $this->timeworks;
    }

    public function addTimework(Timework $timework): self
    {
        if (!$this->timeworks->contains($timework)) {
            $this->timeworks[] = $timework;
            $timework->setTicket($this);
        }

        return $this;
    }

    public function removeTimework(Timework $timework): self
    {
        if ($this->timeworks->removeElement($timework)) {
            // set the owning side to null (unless already changed)
            if ($timework->getTicket() === $this) {
                $timework->setTicket(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Trait\Timestampable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *     fields={"email"},
 *     message="signin.unique_email"
 * )
 * @UniqueEntity(
 *     fields={"username"},
 *     message="signin.unique_username"
 * )
 * @ORM\HasLifecycleCallbacks
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /*
     * Trait
     */
    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=25, unique=true)
     *
     * @Assert\NotBlank(
     *     message="signin.required_username"
     * )
     * @Assert\Length(
     *     min=3,
     *     minMessage="signin.min_char_username"
     * )
     * @Assert\Regex(
     *     pattern="/^[\pL\pM\pN_-]+$/u",
     *     match=true,
     *     message="signin.wrong_char_username"
     * )
     */
    private $username;

    /**
     * @var int
     *
     * @ORM\Column(name="provider_id", type="integer", nullable=true)
     */
    private $providerId;

    /**
     * @var string
     *
     * @Assert\NotBlank(
     *     message="signin.required_password"
     * )
     * @Assert\Length(
     *     min=6,
     *     max=4096,
     *     minMessage="signin.min_char_password"
     * )
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private ?string $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @ORM\OneToOne(targetEntity=Profile::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $profile;

    /**
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="author")
     */
    private $tasks;

    /**
     * @ORM\ManyToMany(targetEntity=Project::class, mappedBy="members")
     */
    private $projects;

    /**
     * @ORM\OneToMany(targetEntity=Timework::class, mappedBy="user")
     */
    private $timeworks;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, mappedBy="members")
     */
    private $events;

    /**
     * @var string
     *
     * @ORM\Column(name="reset_password_token", type="string", unique=true, nullable=true)
     */
    private $resetPasswordToken;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="token_expiration_date", type="datetime", nullable=true)
     */
    private $tokenExpirationDate;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="user", orphanRemoval=true, cascade={"persist"})
     */
    private $messages;

    /**
     * @ORM\ManyToMany(targetEntity=GroupConversation::class, inversedBy="users", cascade={"persist"})
     */
    private $conversations;

    /**
     * @ORM\OneToMany(targetEntity=GroupConversation::class, mappedBy="admin", cascade={"persist"})
     */
    private $adminGroupConversations;

    public function __construct()
    {
        $this->tasks                    = new ArrayCollection();
        $this->projects                 = new ArrayCollection();
        $this->timeworks                = new ArrayCollection();
        $this->events                   = new ArrayCollection();
        $this->comments                 = new ArrayCollection();
        $this->messages                 = new ArrayCollection();
        $this->conversations            = new ArrayCollection();
        $this->adminGroupConversations  = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->email;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        if (empty($rols)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }


    public function serialize(): ?string
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password,
        ]);
    }

    public function unserialize($serialized): void
    {
        list(
            $this->id,
            $this->username,
            $this->password) = unserialize($serialized);
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getProviderId(): ?int
    {
        return $this->providerId;
    }

    public function setProviderId(int $providerId): void
    {
        $this->providerId = $providerId;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getResetPasswordToken(): ?string
    {
        return $this->resetPasswordToken;
    }

    public function setResetPasswordToken(?string $resetPasswordToken = null): self
    {
        $this->resetPasswordToken = $resetPasswordToken;

        return $this;
    }

    public function getTokenExpirationDate(): ?\DateTime
    {
        return $this->tokenExpirationDate;
    }

    public function setTokenExpirationDate(): self
    {
        $date = new \DateTime();
        $date->add(new \DateInterval('PT1H'));
        $this->tokenExpirationDate = $date;

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): self
    {
        // unset the owning side of the relation if necessary
        if ($profile === null && $this->profile !== null) {
            $this->profile->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($profile !== null && $profile->getUser() !== $this) {
            $profile->setUser($this);
        }

        $this->profile = $profile;

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setAuthor($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getAuthor() === $this) {
                $task->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->addMember($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->removeElement($project)) {
            $project->removeMember($this);
        }

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
            $timework->setUser($this);
        }

        return $this;
    }

    public function removeTimework(Timework $timework): self
    {
        if ($this->timeworks->removeElement($timework)) {
            // set the owning side to null (unless already changed)
            if ($timework->getUser() === $this) {
                $timework->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->addMember($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            $event->removeMember($this);
        }

        return $this;
    }

    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setUser($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getUser() === $this) {
                $message->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|GroupConversation[]
     */
    public function getConversations(): Collection
    {
        return $this->conversations;
    }

    public function addConversation(GroupConversation $conversation): self
    {
        if (!$this->conversations->contains($conversation)) {
            $this->conversations[] = $conversation;
        }

        return $this;
    }

    public function removeConversation(GroupConversation $conversation): self
    {
        $this->conversations->removeElement($conversation);

        return $this;
    }

    /**
     * @return Collection|GroupConversation[]
     */
    public function getAdminGroupConversations(): Collection
    {
        return $this->adminGroupConversations;
    }

    public function addGroupConversation(GroupConversation $groupConversation): self
    {
        if (!$this->adminGroupConversations->contains($groupConversation)) {
            $this->adminGroupConversations[] = $groupConversation;
            $groupConversation->setAdmin($this);
        }

        return $this;
    }

    public function removeGroupConversation(GroupConversation $groupConversation): self
    {
        if ($this->adminGroupConversations->removeElement($groupConversation)) {
            // set the owning side to null (unless already changed)
            if ($groupConversation->getAdmin() === $this) {
                $groupConversation->setAdmin(null);
            }
        }

        return $this;
    }
}

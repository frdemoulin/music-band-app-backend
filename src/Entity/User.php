<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this username')]
class User implements UserInterface, \Stringable, PasswordAuthenticatedUserInterface
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\NotBlank(message: 'Veuillez renseigner une adresse email')]
    private ?string $email = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(type: 'string')]
    private ?string $password = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Veuillez renseigner un prénom')]
    private ?string $firstname = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Veuillez renseigner un nom')]
    private ?string $lastname = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $nickname = null;

    #[ORM\OneToMany(targetEntity: Setlist::class, mappedBy: 'createdBy')]
    private Collection $setlistsCreatedBy;

    #[ORM\OneToMany(targetEntity: Setlist::class, mappedBy: 'lastModifiedBy')]
    private Collection $setlistsLastModifiedBy;

    #[ORM\OneToMany(targetEntity: LogUser::class, mappedBy: 'user', cascade: ['remove'])]
    private Collection $logUsers;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $sessionId = null;

    public function __construct()
    {
        $this->setlistsCreatedBy = new ArrayCollection();
        $this->setlistsLastModifiedBy = new ArrayCollection();
        $this->logUsers = new ArrayCollection();
    }

    public function __toString(): string
    {
        return (string) $this->getFirstnameLastnameDescription();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstnameLastnameDescription(): ?string
    {
        return mb_convert_case((string) $this->firstname, MB_CASE_TITLE, 'UTF-8') . ' ' . mb_strtoupper((string) $this->lastname, 'UTF-8');
    }

    public function getLastnameFirstnameDescription(): ?string
    {
        return mb_strtoupper((string) $this->lastname, 'UTF-8') . ' ' . mb_convert_case((string) $this->firstname, MB_CASE_TITLE, 'UTF-8');
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(?string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * @return Collection|Setlist[]
     */
    public function getSetlistsCreatedBy(): Collection
    {
        return $this->setlistsCreatedBy;
    }

    public function addSetlistsCreatedBy(Setlist $setlistsCreatedBy): self
    {
        if (!$this->setlistsCreatedBy->contains($setlistsCreatedBy)) {
            $this->setlistsCreatedBy[] = $setlistsCreatedBy;
            $setlistsCreatedBy->setCreatedBy($this);
        }

        return $this;
    }

    public function removeSetlistsCreatedBy(Setlist $setlistsCreatedBy): self
    {
        if ($this->setlistsCreatedBy->removeElement($setlistsCreatedBy)) {
            // set the owning side to null (unless already changed)
            if ($setlistsCreatedBy->getCreatedBy() === $this) {
                $setlistsCreatedBy->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Setlist[]
     */
    public function getSetlistsLastModifiedBy(): Collection
    {
        return $this->setlistsLastModifiedBy;
    }

    public function addSetlistsLastModifiedBy(Setlist $setlistsLastModifiedBy): self
    {
        if (!$this->setlistsLastModifiedBy->contains($setlistsLastModifiedBy)) {
            $this->setlistsLastModifiedBy[] = $setlistsLastModifiedBy;
            $setlistsLastModifiedBy->setLastModifiedBy($this);
        }

        return $this;
    }

    public function removeSetlistsLastModifiedBy(Setlist $setlistsLastModifiedBy): self
    {
        if ($this->setlistsLastModifiedBy->removeElement($setlistsLastModifiedBy)) {
            // set the owning side to null (unless already changed)
            if ($setlistsLastModifiedBy->getLastModifiedBy() === $this) {
                $setlistsLastModifiedBy->setLastModifiedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|LogUser[]
     */
    public function getLogUsers(): Collection
    {
        return $this->logUsers;
    }

    public function addLogUser(LogUser $logUser): self
    {
        if (!$this->logUsers->contains($logUser)) {
            $this->logUsers[] = $logUser;
            $logUser->setUser($this);
        }

        return $this;
    }

    public function removeLogUser(LogUser $logUser): self
    {
        if ($this->logUsers->removeElement($logUser)) {
            // set the owning side to null (unless already changed)
            if ($logUser->getUser() === $this) {
                $logUser->setUser(null);
            }
        }

        return $this;
    }

    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    public function setSessionId(?string $sessionId): self
    {
        $this->sessionId = $sessionId;

        return $this;
    }
}

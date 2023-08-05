<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SetlistRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SetlistRepository::class)]
class Setlist
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\NotBlank(message: 'Veuillez renseigner une description')]
    private $description;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'setlistsCreatedBy')]
    private $createdBy;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'setlistsLastModifiedBy')]
    private $lastModifiedBy;

    #[ORM\OneToMany(targetEntity: SetlistEntry::class, mappedBy: 'setlist', orphanRemoval: true)]
    private $setlistEntries;

    public function __construct()
    {
        $this->setlistEntries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getLastModifiedBy(): ?User
    {
        return $this->lastModifiedBy;
    }

    public function setLastModifiedBy(?User $lastModifiedBy): self
    {
        $this->lastModifiedBy = $lastModifiedBy;

        return $this;
    }

    /**
     * @return Collection|SetlistEntry[]
     */
    public function getSetlistEntries(): Collection
    {
        return $this->setlistEntries;
    }

    public function addSetlistEntry(SetlistEntry $setlistEntry): self
    {
        if (!$this->setlistEntries->contains($setlistEntry)) {
            $this->setlistEntries[] = $setlistEntry;
            $setlistEntry->setSetlist($this);
        }

        return $this;
    }

    public function removeSetlistEntry(SetlistEntry $setlistEntry): self
    {
        if ($this->setlistEntries->removeElement($setlistEntry)) {
            // set the owning side to null (unless already changed)
            if ($setlistEntry->getSetlist() === $this) {
                $setlistEntry->setSetlist(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Repository\BackingTrackSortRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: BackingTrackSortRepository::class)]
class BackingTrackSort
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\OneToMany(targetEntity: BackingTrack::class, mappedBy: 'backingTrackSort', fetch: 'EAGER')]
    private $backingTracks;

    public function __construct()
    {
        $this->backingTracks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection|BackingTrack[]
     */
    public function getBackingTracks(): Collection
    {
        return $this->backingTracks;
    }

    public function addBackingTrack(BackingTrack $backingTrack): self
    {
        if (!$this->backingTracks->contains($backingTrack)) {
            $this->backingTracks[] = $backingTrack;
            $backingTrack->setBackingTrackSort($this);
        }

        return $this;
    }

    public function removeBackingTrack(BackingTrack $backingTrack): self
    {
        if ($this->backingTracks->removeElement($backingTrack)) {
            // set the owning side to null (unless already changed)
            if ($backingTrack->getBackingTrackSort() === $this) {
                $backingTrack->setBackingTrackSort(null);
            }
        }

        return $this;
    }
}

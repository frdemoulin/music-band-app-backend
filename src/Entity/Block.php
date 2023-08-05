<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BlockRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: BlockRepository::class)]
class Block
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $duration;

    #[ORM\OneToMany(targetEntity: BlockHasCovers::class, mappedBy: 'block', orphanRemoval: true, fetch: 'EAGER', cascade: ['persist', 'remove'])]
    #[ORM\OrderBy(['coverRankInBlock' => 'ASC'])]
    private $blockHasCovers;

    #[ORM\OneToMany(targetEntity: BackingTrack::class, mappedBy: 'block', fetch: 'EAGER', cascade: ['persist', 'remove'])]
    private $backingTracks;

    #[ORM\OneToMany(targetEntity: SetlistEntry::class, mappedBy: 'block', orphanRemoval: false)]
    private $setlistEntries;

    #[ORM\OneToOne(targetEntity: Ending::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(onDelete: 'SET NULL')]
    private $ending;

    public function __construct()
    {
        $this->blockHasCovers = new ArrayCollection();
        $this->backingTracks = new ArrayCollection();
        $this->setlistEntries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return Collection|BlockHasCovers[]
     */
    public function getBlockHasCovers(): Collection
    {
        return $this->blockHasCovers;
    }

    public function addBlockHasCover(BlockHasCovers $blockHasCover): self
    {
        if (!$this->blockHasCovers->contains($blockHasCover)) {
            $this->blockHasCovers[] = $blockHasCover;
            $blockHasCover->setBlock($this);
        }

        return $this;
    }

    public function removeBlockHasCover(BlockHasCovers $blockHasCover): self
    {
        if ($this->blockHasCovers->removeElement($blockHasCover)) {
            // set the owning side to null (unless already changed)
            if ($blockHasCover->getBlock() === $this) {
                $blockHasCover->setBlock(null);
            }
        }

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
            $backingTrack->setBlock($this);
        }

        return $this;
    }

    public function removeBackingTrack(BackingTrack $backingTrack): self
    {
        if ($this->backingTracks->removeElement($backingTrack)) {
            // set the owning side to null (unless already changed)
            if ($backingTrack->getBlock() === $this) {
                $backingTrack->setBlock(null);
            }
        }

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
            $setlistEntry->setBlock($this);
        }

        return $this;
    }

    public function removeSetlistEntry(SetlistEntry $setlistEntry): self
    {
        if ($this->setlistEntries->removeElement($setlistEntry)) {
            // set the owning side to null (unless already changed)
            if ($setlistEntry->getBlock() === $this) {
                $setlistEntry->setBlock(null);
            }
        }

        return $this;
    }

    public function getEnding(): ?Ending
    {
        return $this->ending;
    }

    public function setEnding(?Ending $ending): self
    {
        $this->ending = $ending;

        return $this;
    }
}

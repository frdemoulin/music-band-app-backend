<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BackingTrackRepository;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: BackingTrackRepository::class)]
class BackingTrack
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private $id;

    #[ORM\ManyToOne(targetEntity: BackingTrackSort::class, inversedBy: 'backingTracks', fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private ?\App\Entity\BackingTrackSort $backingTrackSort = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $filename = null;

    #[ORM\Column(type: 'integer')]
    private ?int $duration = null;

    #[ORM\ManyToOne(targetEntity: Cover::class, inversedBy: 'backingTracks')]
    #[ORM\JoinColumn(nullable: true)]
    private ?\App\Entity\Cover $cover = null;

    #[ORM\ManyToOne(targetEntity: Block::class, inversedBy: 'backingTracks')]
    private ?\App\Entity\Block $block = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBackingTrackSort(): ?BackingTrackSort
    {
        return $this->backingTrackSort;
    }

    public function setBackingTrackSort(?BackingTrackSort $backingTrackSort): self
    {
        $this->backingTrackSort = $backingTrackSort;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getCover(): ?Cover
    {
        return $this->cover;
    }

    public function setCover(?Cover $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getBlock(): ?Block
    {
        return $this->block;
    }

    public function setBlock(?Block $block): self
    {
        $this->block = $block;

        return $this;
    }
}

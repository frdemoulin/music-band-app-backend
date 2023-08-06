<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SetlistEntryRepository;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: SetlistEntryRepository::class)]
class SetlistEntry
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private $id;

    #[ORM\Column(type: 'integer')]
    private ?int $rankInSetlist = null;

    #[ORM\ManyToOne(targetEntity: Setlist::class, inversedBy: 'setlistEntries')]
    #[ORM\JoinColumn(nullable: false)]
    private ?\App\Entity\Setlist $setlist = null;

    #[ORM\ManyToOne(targetEntity: Block::class, inversedBy: 'setlistEntries')]
    private ?\App\Entity\Block $block = null;

    #[ORM\ManyToOne(targetEntity: Cover::class, inversedBy: 'setlistEntries')]
    private ?\App\Entity\Cover $cover = null;

    #[ORM\ManyToOne(targetEntity: Speech::class)]
    private ?\App\Entity\Speech $speech = null;

    #[ORM\ManyToOne(targetEntity: Intermission::class)]
    private ?\App\Entity\Intermission $intermission = null;

    #[ORM\ManyToOne(targetEntity: SetlistEntrySort::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?\App\Entity\SetlistEntrySort $sort = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRankInSetlist(): ?int
    {
        return $this->rankInSetlist;
    }

    public function setRankInSetlist(int $rankInSetlist): self
    {
        $this->rankInSetlist = $rankInSetlist;

        return $this;
    }

    public function getSetlist(): ?Setlist
    {
        return $this->setlist;
    }

    public function setSetlist(?Setlist $setlist): self
    {
        $this->setlist = $setlist;

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

    public function getCover(): ?Cover
    {
        return $this->cover;
    }

    public function setCover(?Cover $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getSpeech(): ?Speech
    {
        return $this->speech;
    }

    public function setSpeech(?Speech $speech): self
    {
        $this->speech = $speech;

        return $this;
    }

    public function getIntermission(): ?Intermission
    {
        return $this->intermission;
    }

    public function setIntermission(?Intermission $intermission): self
    {
        $this->intermission = $intermission;

        return $this;
    }

    public function getSort(): ?SetlistEntrySort
    {
        return $this->sort;
    }

    public function setSort(?SetlistEntrySort $sort): self
    {
        $this->sort = $sort;

        return $this;
    }
}

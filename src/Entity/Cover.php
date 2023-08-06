<?php

namespace App\Entity;

use App\Repository\CoverRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CoverRepository::class)]
class Cover
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private $id;

    #[ORM\ManyToOne(targetEntity: Song::class, inversedBy: 'covers')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: 'Veuillez choisir une chanson')]
    private ?\App\Entity\Song $song = null;

    #[ORM\ManyToOne(targetEntity: IntroOutro::class, inversedBy: 'coversIntro')]
    private ?\App\Entity\IntroOutro $intro = null;

    #[ORM\ManyToOne(targetEntity: IntroOutro::class, inversedBy: 'coversOutro')]
    private ?\App\Entity\IntroOutro $outro = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $duration = null;

    #[ORM\OneToMany(targetEntity: BackingTrack::class, mappedBy: 'cover', orphanRemoval: true, cascade: ['persist'], fetch: 'EAGER')]
    private Collection $backingTracks;

    #[ORM\OneToMany(targetEntity: BlockHasCovers::class, mappedBy: 'cover', orphanRemoval: true)]
    private Collection $blockHasCovers;

    #[ORM\OneToMany(targetEntity: SetlistEntry::class, mappedBy: 'cover')]
    private Collection $setlistEntries;

    #[ORM\OneToOne(targetEntity: Ending::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(onDelete: 'SET NULL')]
    private ?\App\Entity\Ending $ending = null;

    public function __construct()
    {
        $this->backingTracks = new ArrayCollection();
        $this->blockHasCovers = new ArrayCollection();
        $this->setlistEntries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSong(): ?Song
    {
        return $this->song;
    }

    /**
     * Retourne la description des intro / outro d'un cover sous la forme d'une chaîne de caractère.
     *
     * @param bool   $brackets Retourne la chaîne entre parenthèses si true
     * @param string $format   Retourne nom de l'artiste et titre de l'intro / outro si à full, que le titre si à light
     */
    public function getCoverIntroOutroDescription(bool $brackets = true, string $format = 'full'): ?string
    {
        $stringToReturn = null;
        if (null !== $this->getIntro() && null === $this->getOutro()) { // intro seule
            if ($brackets) {
                if (isset($format) && 'full' === $format) {
                    $stringToReturn = '(intro '.$this->getIntro()->getArtistName().' - '.$this->getIntro()->getSongTitle().')';
                } elseif (isset($format) && 'light' === $format) {
                    $stringToReturn = '(intro '.$this->getIntro()->getSongTitle().')';
                }
            } else {
                if (isset($format) && 'full' === $format) {
                    $stringToReturn = 'intro '.$this->getIntro()->getArtistName().' - '.$this->getIntro()->getSongTitle();
                } elseif (isset($format) && 'light' === $format) {
                    $stringToReturn = 'intro '.$this->getIntro()->getSongTitle();
                }
            }
        } elseif (null === $this->getIntro() && null !== $this->getOutro()) { // outro seule
            if ($brackets) {
                if (isset($format) && 'full' === $format) {
                    $stringToReturn = '(outro '.$this->getOutro()->getArtistName().' - '.$this->getOutro()->getSongTitle().')';
                } elseif (isset($format) && 'light' === $format) {
                    $stringToReturn = '(outro '.$this->getOutro()->getSongTitle().')';
                }
            } else {
                if (isset($format) && 'full' === $format) {
                    $stringToReturn = 'outro '.$this->getOutro()->getArtistName().' - '.$this->getOutro()->getSongTitle();
                } elseif (isset($format) && 'light' === $format) {
                    $stringToReturn = 'outro '.$this->getOutro()->getSongTitle();
                }
            }
        } elseif (null !== $this->getIntro() && null !== $this->getOutro()) { // intro et outro
            if ($brackets) {
                if (isset($format) && 'full' === $format) {
                    $stringToReturn = '(intro '.$this->getIntro()->getArtistName().' - '.$this->getIntro()->getSongTitle().', outro '.$this->getOutro()->getArtistName().' - '.$this->getOutro()->getSongTitle().')';
                } elseif (isset($format) && 'light' === $format) {
                    $stringToReturn = '(intro '.$this->getIntro()->getSongTitle().', outro '.$this->getOutro()->getSongTitle().')';
                }
            } else {
                if (isset($format) && 'full' === $format) {
                    $stringToReturn = 'intro '.$this->getIntro()->getArtistName().' - '.$this->getIntro()->getSongTitle().', outro '.$this->getOutro()->getArtistName().' - '.$this->getOutro()->getSongTitle();
                } elseif (isset($format) && 'light' === $format) {
                    $stringToReturn = 'intro '.$this->getIntro()->getSongTitle().', outro '.$this->getOutro()->getSongTitle();
                }
            }
        } else { // ni intro ni outro
            $stringToReturn = null;
        }

        return $stringToReturn;
    }

    /**
     * Retourne le chemin relatif vers la fin d'un cover.
     */
    public function getCoverEndingPath(): ?string
    {
        return 'assets/audio/cover/'.$this->getEnding()->getFilename();
    }

    public function setSong(?Song $song): self
    {
        $this->song = $song;

        return $this;
    }

    public function getIntro(): ?IntroOutro
    {
        return $this->intro;
    }

    public function setIntro(?IntroOutro $intro): self
    {
        $this->intro = $intro;

        return $this;
    }

    public function getOutro(): ?IntroOutro
    {
        return $this->outro;
    }

    public function setOutro(?IntroOutro $outro): self
    {
        $this->outro = $outro;

        return $this;
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
            $backingTrack->setCover($this);
        }

        return $this;
    }

    public function removeBackingTrack(BackingTrack $backingTrack): self
    {
        if ($this->backingTracks->removeElement($backingTrack)) {
            // set the owning side to null (unless already changed)
            if ($backingTrack->getCover() === $this) {
                $backingTrack->setCover(null);
            }
        }

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
            $blockHasCover->setCover($this);
        }

        return $this;
    }

    public function removeBlockHasCover(BlockHasCovers $blockHasCover): self
    {
        if ($this->blockHasCovers->removeElement($blockHasCover)) {
            // set the owning side to null (unless already changed)
            if ($blockHasCover->getCover() === $this) {
                $blockHasCover->setCover(null);
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
            $setlistEntry->setCover($this);
        }

        return $this;
    }

    public function removeSetlistEntry(SetlistEntry $setlistEntry): self
    {
        if ($this->setlistEntries->removeElement($setlistEntry)) {
            // set the owning side to null (unless already changed)
            if ($setlistEntry->getCover() === $this) {
                $setlistEntry->setCover(null);
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

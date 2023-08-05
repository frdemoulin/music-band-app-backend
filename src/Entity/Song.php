<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SongRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SongRepository::class)]
class Song
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Veuillez renseigner un titre')]
    private $title;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(message: 'Veuillez renseigner une durée')]
    #[Assert\NotNull(message: 'Veuillez renseigner une durée')]
    private $duration;

    #[ORM\ManyToOne(targetEntity: Tuning::class, inversedBy: 'songs')]
    private $tuning;

    #[ORM\ManyToOne(targetEntity: Album::class, inversedBy: 'songs')]
    private $album;

    #[ORM\OneToMany(targetEntity: Cover::class, mappedBy: 'song')]
    private $covers;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $shortTitle;

    public function __construct()
    {
        $this->covers = new ArrayCollection();
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

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): self
    {
        $this->album = $album;

        return $this;
    }

    public function getTuning(): ?Tuning
    {
        return $this->tuning;
    }

    public function setTuning(?Tuning $tuning): self
    {
        $this->tuning = $tuning;

        return $this;
    }

    /**
     * @return Collection|Cover[]
     */
    public function getCovers(): Collection
    {
        return $this->covers;
    }

    public function addCover(Cover $cover): self
    {
        if (!$this->covers->contains($cover)) {
            $this->covers[] = $cover;
            $cover->setSong($this);
        }

        return $this;
    }

    public function removeCover(Cover $cover): self
    {
        if ($this->covers->removeElement($cover)) {
            // set the owning side to null (unless already changed)
            if ($cover->getSong() === $this) {
                $cover->setSong(null);
            }
        }

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

    public function getShortTitle(): ?string
    {
        return $this->shortTitle;
    }

    public function setShortTitle(?string $shortTitle): self
    {
        $this->shortTitle = $shortTitle;

        return $this;
    }
}

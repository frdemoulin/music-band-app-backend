<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: IntroOutroRepository::class)]
class IntroOutro
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $artistName = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Le titre ne peut pas être vide')]
    private ?string $songTitle = null;

    #[ORM\OneToMany(targetEntity: Cover::class, mappedBy: 'intro')]
    private Collection $coversIntro;

    #[ORM\OneToMany(targetEntity: Cover::class, mappedBy: 'outro')]
    private Collection $coversOutro;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $duration = null;

    public function __construct()
    {
        $this->outro = new ArrayCollection();
        $this->covers = new ArrayCollection();
        $this->coversIntro = new ArrayCollection();
        $this->coversOutro = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArtistName(): ?string
    {
        return $this->artistName;
    }

    public function setArtistName(?string $artistName): self
    {
        $this->artistName = $artistName;

        return $this;
    }

    public function getSongTitle(): ?string
    {
        return $this->songTitle;
    }

    public function setSongTitle(string $songTitle): self
    {
        $this->songTitle = $songTitle;

        return $this;
    }

    public function addCover(Cover $cover): self
    {
        if (!$this->covers->contains($cover)) {
            $this->covers[] = $cover;
            $cover->setIntro($this);
        }

        return $this;
    }

    public function removeCover(Cover $cover): self
    {
        if ($this->covers->removeElement($cover)) {
            // set the owning side to null (unless already changed)
            if ($cover->getIntro() === $this) {
                $cover->setIntro(null);
            }
        }

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
     * @return Collection|Cover[]
     */
    public function getCoversIntro(): Collection
    {
        return $this->coversIntro;
    }

    public function addCoversIntro(Cover $coversIntro): self
    {
        if (!$this->coversIntro->contains($coversIntro)) {
            $this->coversIntro[] = $coversIntro;
            $coversIntro->setIntro($this);
        }

        return $this;
    }

    public function removeCoversIntro(Cover $coversIntro): self
    {
        if ($this->coversIntro->removeElement($coversIntro)) {
            // set the owning side to null (unless already changed)
            if ($coversIntro->getIntro() === $this) {
                $coversIntro->setIntro(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Cover[]
     */
    public function getCoversOutro(): Collection
    {
        return $this->coversOutro;
    }

    public function addCoversOutro(Cover $coversOutro): self
    {
        if (!$this->coversOutro->contains($coversOutro)) {
            $this->coversOutro[] = $coversOutro;
            $coversOutro->setOutro($this);
        }

        return $this;
    }

    public function removeCoversOutro(Cover $coversOutro): self
    {
        if ($this->coversOutro->removeElement($coversOutro)) {
            // set the owning side to null (unless already changed)
            if ($coversOutro->getOutro() === $this) {
                $coversOutro->setOutro(null);
            }
        }

        return $this;
    }
}

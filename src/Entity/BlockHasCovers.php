<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BlockHasCoversRepository;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BlockHasCoversRepository::class)]
class BlockHasCovers
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(message: 'Veuillez renseigner un rang')]
    private ?int $coverRankInBlock = null;

    #[ORM\ManyToOne(targetEntity: Block::class, inversedBy: 'blockHasCovers', fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private ?\App\Entity\Block $block = null;

    #[ORM\ManyToOne(targetEntity: Cover::class, inversedBy: 'blockHasCovers', fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private ?\App\Entity\Cover $cover = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCoverRankInBlock(): ?int
    {
        return $this->coverRankInBlock;
    }

    public function setCoverRankInBlock(int $coverRankInBlock): self
    {
        $this->coverRankInBlock = $coverRankInBlock;

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
}

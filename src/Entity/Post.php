<?php

namespace App\Entity;

use App\Entity\Traits\HasIdTrait;
use App\Entity\Traits\HasNameTrait;
use App\Entity\Traits\HasDescriptionTrait;
use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    use HasIdTrait;
    use HasNameTrait;
    use HasDescriptionTrait;
    use TimestampableEntity;  //c'est un trait dont l'appelation ne se termine pas par "Trait" !!!

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $name = null;

    #[ORM\Column(length: 128)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?bool $draft = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $cooking = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $break = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $preparation = null;

    /**
     * @var Collection<int, Step>
     */
    #[ORM\OneToMany(targetEntity: Step::class, mappedBy: 'post', orphanRemoval: true)]
    private Collection $steps;

    public function __construct()
    {
        $this->steps = new ArrayCollection();
    }

    //#[ORM\Column]
    //private ?\DateTimeImmutable $createdAt = null;

    //#[ORM\Column]
    //private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function isDraft(): ?bool
    {
        return $this->draft;
    }

    public function setDraft(bool $draft): static
    {
        $this->draft = $draft;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCooking(): ?int
    {
        return $this->cooking;
    }

    public function setCooking(?int $cooking): static
    {
        $this->cooking = $cooking;

        return $this;
    }

    public function getBreak(): ?int
    {
        return $this->break;
    }

    public function setBreak(?int $break): static
    {
        $this->break = $break;

        return $this;
    }

    public function getPreparation(): ?int
    {
        return $this->preparation;
    }

    public function setPreparation(?int $preparation): static
    {
        $this->preparation = $preparation;

        return $this;
    }

    //public function getCreatedAt(): ?\DateTimeImmutable
    //{
    //    return $this->createdAt;
    //}

    //public function setCreatedAt(\DateTimeImmutable $createdAt): static
    //{
    //   $this->createdAt = $createdAt;

    //    return $this;
    //}

    //public function getUpdatedAt(): ?\DateTimeImmutable
    //{
    //    return $this->updatedAt;
    //}

    //public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    //{
    //    $this->updatedAt = $updatedAt;

    //    return $this;
    //}

    /**
     * @return Collection<int, Step>
     */
    public function getSteps(): Collection
    {
        return $this->steps;
    }

    public function addStep(Step $step): static
    {
        if (!$this->steps->contains($step)) {
            $this->steps->add($step);
            $step->setPost($this);
        }

        return $this;
    }

    public function removeStep(Step $step): static
    {
        if ($this->steps->removeElement($step)) {
            // set the owning side to null (unless already changed)
            if ($step->getPost() === $this) {
                $step->setPost(null);
            }
        }

        return $this;
    }
}

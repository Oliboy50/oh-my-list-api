<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *   collectionOperations={
 *     "get"={"method"="GET"},
 *     "post"={
 *       "method"="POST",
 *       "denormalization_context"={"groups"={"Listitem_denormalization_post"}},
 *     },
 *   },
 *   itemOperations={
 *     "get"={"method"="GET"},
 *     "put"={
 *       "method"="PUT",
 *       "denormalization_context"={"groups"={"Listitem_denormalization_put"}},
 *     },
 *   }
 * )
 *
 * @ORM\Entity(repositoryClass="App\Repository\ListitemRepository")
 *
 * @UniqueEntity(fields={"label", "owner"})
 */
class Listitem
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank()
     *
     * @Groups("Listitem_denormalization_post")
     * @Groups("Listitem_denormalization_put")
     */
    private $label;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Groups("Listitem_denormalization_post")
     * @Groups("Listitem_denormalization_put")
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="listitems")
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Position", mappedBy="listitem", orphanRemoval=true, cascade={"persist"})
     *
     * @Groups("Listitem_denormalization_post")
     * @Groups("Listitem_denormalization_put")
     */
    private $positions;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="listitems")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Groups("Listitem_denormalization_post")
     */
    private $owner;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->positions = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }

    /**
     * @return Collection|Position[]
     */
    public function getPositions(): Collection
    {
        return $this->positions;
    }

    public function addPosition(Position $position): self
    {
        if (!$this->positions->contains($position)) {
            $this->positions[] = $position;
            $position->setListitem($this);
        }

        return $this;
    }

    public function removePosition(Position $position): self
    {
        if ($this->positions->contains($position)) {
            $this->positions->removeElement($position);
            // set the owning side to null (unless already changed)
            if ($position->getListitem() === $this) {
                $position->setListitem(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}

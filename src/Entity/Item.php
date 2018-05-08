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
 *     "post"={"method"="POST"},
 *   },
 *   itemOperations={
 *     "get"={"method"="GET"},
 *     "put"={"method"="PUT"},
 *   }
 * )
 *
 * @ORM\Entity(repositoryClass="App\Repository\ItemRepository")
 *
 * @UniqueEntity("label")
 */
class Item
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
     */
    private $label;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Groups("Listitem_denormalization_post")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=510, nullable=true)
     *
     * @Groups("Listitem_denormalization_post")
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="items")
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Position", mappedBy="item", orphanRemoval=true)
     */
    private $positions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ItemUser", mappedBy="item", orphanRemoval=true, cascade={"persist"})
     *
     * @Groups("Listitem_denormalization_post")
     */
    private $itemUsers;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->positions = new ArrayCollection();
        $this->itemUsers = new ArrayCollection();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

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
            $position->setItem($this);
        }

        return $this;
    }

    public function removePosition(Position $position): self
    {
        if ($this->positions->contains($position)) {
            $this->positions->removeElement($position);
            // set the owning side to null (unless already changed)
            if ($position->getItem() === $this) {
                $position->setItem(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ItemUser[]
     */
    public function getItemUsers(): Collection
    {
        return $this->itemUsers;
    }

    public function addItemUser(ItemUser $itemUser): self
    {
        if (!$this->itemUsers->contains($itemUser)) {
            $this->itemUsers[] = $itemUser;
            $itemUser->setItem($this);
        }

        return $this;
    }

    public function removeItemUser(ItemUser $itemUser): self
    {
        if ($this->itemUsers->contains($itemUser)) {
            $this->itemUsers->removeElement($itemUser);
            // set the owning side to null (unless already changed)
            if ($itemUser->getItem() === $this) {
                $itemUser->setItem(null);
            }
        }

        return $this;
    }
}

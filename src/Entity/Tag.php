<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
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
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 *
 * @UniqueEntity(fields={"type", "label"})
 */
class Tag
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     *
     * @Assert\NotBlank()
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank()
     */
    private $label;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Item", mappedBy="tags")
     */
    private $items;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Listitem", mappedBy="tags")
     */
    private $listitems;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->listitems = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
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

    /**
     * @return Collection|Item[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->addTag($this);
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            $item->removeTag($this);
        }

        return $this;
    }

    /**
     * @return Collection|Listitem[]
     */
    public function getListitems(): Collection
    {
        return $this->listitems;
    }

    public function addListitem(Listitem $listitem): self
    {
        if (!$this->listitems->contains($listitem)) {
            $this->listitems[] = $listitem;
            $listitem->addTag($this);
        }

        return $this;
    }

    public function removeListitem(Listitem $listitem): self
    {
        if ($this->listitems->contains($listitem)) {
            $this->listitems->removeElement($listitem);
            $listitem->removeTag($this);
        }

        return $this;
    }
}

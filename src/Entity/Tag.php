<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
 */
class Tag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Item", mappedBy="tags")
     */
    private $items;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ItemList", mappedBy="tags")
     */
    private $itemLists;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->itemLists = new ArrayCollection();
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
     * @return Collection|ItemList[]
     */
    public function getItemLists(): Collection
    {
        return $this->itemLists;
    }

    public function addItemList(ItemList $itemList): self
    {
        if (!$this->itemLists->contains($itemList)) {
            $this->itemLists[] = $itemList;
            $itemList->addTag($this);
        }

        return $this;
    }

    public function removeItemList(ItemList $itemList): self
    {
        if ($this->itemLists->contains($itemList)) {
            $this->itemLists->removeElement($itemList);
            $itemList->removeTag($this);
        }

        return $this;
    }
}

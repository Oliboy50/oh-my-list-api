<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *   collectionOperations={
 *     "get"={
 *       "method"="GET",
 *       "normalization_context"={"groups"={"Position_normalization_list"}},
 *     },
 *   },
 *   itemOperations={
 *     "get"={
 *       "method"="GET",
 *       "normalization_context"={"groups"={"Position_normalization_get"}},
 *     },
 *   }
 * )
 *
 * @ORM\Entity(repositoryClass="App\Repository\PositionRepository")
 *
 * @UniqueEntity(fields={"item", "listitem"})
 * @UniqueEntity(fields={"listitem", "position"})
 */
class Position
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item", inversedBy="positions", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\NotNull()
     *
     * @Groups("Position_normalization_list")
     * @Groups("Position_normalization_get")
     * @Groups("Listitem_normalization_get")
     * @Groups("Listitem_denormalization_post")
     * @Groups("Listitem_denormalization_put")
     */
    private $item;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Listitem", inversedBy="positions")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\NotNull()
     *
     * @Groups("Position_normalization_list")
     * @Groups("Position_normalization_get")
     */
    private $listitem;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank()
     * @Assert\GreaterThan(0)
     *
     * @Groups("Position_normalization_list")
     * @Groups("Position_normalization_get")
     * @Groups("Listitem_normalization_get")
     * @Groups("Listitem_denormalization_post")
     * @Groups("Listitem_denormalization_put")
     */
    private $position;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Groups("Position_normalization_list")
     * @Groups("Position_normalization_get")
     * @Groups("Listitem_normalization_get")
     * @Groups("Listitem_denormalization_post")
     * @Groups("Listitem_denormalization_put")
     */
    private $description;

    public function getId()
    {
        return $this->id;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getListitem(): ?Listitem
    {
        return $this->listitem;
    }

    public function setListitem(?Listitem $listitem): self
    {
        $this->listitem = $listitem;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

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
}

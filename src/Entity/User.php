<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
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
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 *
 * @UniqueEntity("email")
 */
class User implements UserInterface, \Serializable
{
    use TimestampableEntity;

    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_USER = 'ROLE_USER';

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
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $password;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive = true;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Listitem", mappedBy="owner")
     */
    private $listitems;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ItemUser", mappedBy="user", orphanRemoval=true)
     */
    private $itemUsers;

    public function __construct()
    {
        $this->listitems = new ArrayCollection();
        $this->roles = [self::ROLE_USER];
        $this->itemUsers = new ArrayCollection();
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function getSalt()
    {
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize([$this->id, $this->email, $this->password]);
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list($this->id, $this->email, $this->password) = unserialize($serialized);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setActive(bool $isActive): self
    {
        $this->isActive = $isActive;

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
            $listitem->setOwner($this);
        }

        return $this;
    }

    public function removeListitem(Listitem $listitem): self
    {
        if ($this->listitems->contains($listitem)) {
            $this->listitems->removeElement($listitem);
            // set the owning side to null (unless already changed)
            if ($listitem->getOwner() === $this) {
                $listitem->setOwner(null);
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
            $itemUser->setUser($this);
        }

        return $this;
    }

    public function removeItemUser(ItemUser $itemUser): self
    {
        if ($this->itemUsers->contains($itemUser)) {
            $this->itemUsers->removeElement($itemUser);
            // set the owning side to null (unless already changed)
            if ($itemUser->getUser() === $this) {
                $itemUser->setUser(null);
            }
        }

        return $this;
    }
}

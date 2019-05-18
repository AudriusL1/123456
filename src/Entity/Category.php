<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\user")
     */
    private $sub;

    public function __construct()
    {
        $this->sub = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function __toString()
    {
      return $this->name;
    }

    /**
     * @return Collection|user[]
     */
    public function getSub(): Collection
    {
        return $this->sub;
    }

    public function addSub(user $sub): self
    {
        if (!$this->sub->contains($sub)) {
            $this->sub[] = $sub;
        }

        return $this;
    }

    public function removeSub(user $sub): self
    {
        if ($this->sub->contains($sub)) {
            $this->sub->removeElement($sub);
        }

        return $this;
    }
}

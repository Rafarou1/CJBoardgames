<?php

namespace App\Entity;

use App\Repository\GameClassRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameClassRepository::class)
 */
class GameClass
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=GameClass::class, inversedBy="subClass")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=GameClass::class, mappedBy="parent")
     */
    private $subClass;

    /**
     * @ORM\ManyToMany(targetEntity=Boardgame::class, mappedBy="gameClass")
     */
    private $boardgames;

    public function __construct()
    {
        $this->subClass = new ArrayCollection();
        $this->boardgames = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getSubClass(): Collection
    {
        return $this->subClass;
    }

    public function addSubClass(self $subClass): self
    {
        if (!$this->subClass->contains($subClass)) {
            $this->subClass[] = $subClass;
            $subClass->setParent($this);
        }

        return $this;
    }

    public function removeSubClass(self $subClass): self
    {
        if ($this->subClass->removeElement($subClass)) {
            // set the owning side to null (unless already changed)
            if ($subClass->getParent() === $this) {
                $subClass->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Boardgame>
     */
    public function getBoardgames(): Collection
    {
        return $this->boardgames;
    }

    public function addBoardgame(Boardgame $boardgame): self
    {
        if (!$this->boardgames->contains($boardgame)) {
            $this->boardgames[] = $boardgame;
            $boardgame->addGameClass($this);
        }

        return $this;
    }

    public function removeBoardgame(Boardgame $boardgame): self
    {
        if ($this->boardgames->removeElement($boardgame)) {
            $boardgame->removeGameClass($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}

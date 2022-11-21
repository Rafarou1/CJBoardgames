<?php

namespace App\Entity;

use App\Repository\ArmoireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArmoireRepository::class)
 */
class Armoire
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
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $published;

    /**
     * @ORM\OneToOne(targetEntity=Player::class, cascade={"persist", "remove"})
     */
    private $player;

    /**
     * @ORM\ManyToMany(targetEntity=Boardgame::class, inversedBy="armoires")
     */
    private $boardgame;

    public function __construct()
    {
        $this->boardgame = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function isPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

        return $this;
    }

    /**
     * @return Collection<int, Boardgame>
     */
    public function getBoardgame(): Collection
    {
        return $this->boardgame;
    }

    public function addBoardgame(Boardgame $boardgame): self
    {
        if (!$this->boardgame->contains($boardgame)) {
            $this->boardgame[] = $boardgame;
        }

        return $this;
    }

    public function removeBoardgame(Boardgame $boardgame): self
    {
        $this->boardgame->removeElement($boardgame);

        return $this;
    }

    public function __toString()
    {
        return $this->description;
    }
}

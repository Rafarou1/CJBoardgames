<?php

namespace App\Entity;

use App\Repository\BoardgameRepository;
use App\Entity\Reserve;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BoardgameRepository::class)
 */
class Boardgame
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $difficulty;

    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @ORM\ManyToOne(targetEntity=Reserve::class, inversedBy="boardgame")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reserve;

    /**
     * @ORM\ManyToMany(targetEntity=GameClass::class, inversedBy="boardgames")
     */
    private $gameClass;

    /**
     * @ORM\ManyToMany(targetEntity=Armoire::class, mappedBy="boardgame")
     */
    private $armoires;

    public function __construct()
    {
        $this->gameClass = new ArrayCollection();
        $this->armoires = new ArrayCollection();
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

    public function getDifficulty(): ?int
    {
        return $this->difficulty;
    }

    public function setDifficulty(?int $difficulty): self
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getReserve(): ?Reserve
    {
        return $this->reserve;
    }

    public function setReserve(?Reserve $reserve): self
    {
        $this->reserve = $reserve;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Collection<int, GameClass>
     */
    public function getGameClass(): Collection
    {
        return $this->gameClass;
    }

    public function addGameClass(GameClass $gameClass): self
    {
        if (!$this->gameClass->contains($gameClass)) {
            $this->gameClass[] = $gameClass;
        }

        return $this;
    }

    public function removeGameClass(GameClass $gameClass): self
    {
        $this->gameClass->removeElement($gameClass);

        return $this;
    }

    /**
     * @return Collection<int, Armoire>
     */
    public function getArmoires(): Collection
    {
        return $this->armoires;
    }

    public function addArmoire(Armoire $armoire): self
    {
        if (!$this->armoires->contains($armoire)) {
            $this->armoires[] = $armoire;
            $armoire->addBoardgame($this);
        }

        return $this;
    }

    public function removeArmoire(Armoire $armoire): self
    {
        if ($this->armoires->removeElement($armoire)) {
            $armoire->removeBoardgame($this);
        }

        return $this;
    }

}

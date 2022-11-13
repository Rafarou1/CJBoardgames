<?php

namespace App\Entity;

use App\Repository\ReserveRepository;
use App\Entity\Boardgame;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
// use DateTime;

/**
 * @ORM\Entity(repositoryClass=ReserveRepository::class)
 */
class Reserve
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
     * @ORM\OneToMany(targetEntity=Boardgame::class, mappedBy="reserve")
     */
    private $boardgame;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity=Player::class, mappedBy="reserve", cascade={"persist", "remove"})
     */
    private $player;

    // /**
    //  * @var \Datetime Date of creation
    //  *
    //  * @ORM\Column(name="created", type="datetime")
    //  */
    // private $created;
    
    // /**
    //  * @var \Datetime Date of last modification
    //  *
    //  * @ORM\Column(name="updated", type="datetime")
    //  */
    // private $updated;

    public function __construct()
    {
        $this->boardgame = new ArrayCollection();
        // $this->created = new \DateTime();
        // $this->updated = new \DateTime();

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
            $boardgame->setReserve($this);
        }

        return $this;
    }

    public function removeBoardgame(Boardgame $boardgame): self
    {
        if ($this->boardgame->removeElement($boardgame)) {
            // set the owning side to null (unless already changed)
            if ($boardgame->getReserve() === $this) {
                $boardgame->setReserve(null);
            }
        }

        return $this;
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

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(Player $player): self
    {
        // set the owning side of the relation if necessary
        if ($player->getReserve() !== $this) {
            $player->setReserve($this);
        }

        $this->player = $player;

        return $this;
    }
}

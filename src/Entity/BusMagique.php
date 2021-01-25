<?php

namespace App\Entity;

use App\Repository\BusMagiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BusMagiqueRepository::class)
 */
class BusMagique
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
    private $player;

    /**
     * @ORM\Column(type="integer")
     */
    private $km;

    /**
     * @ORM\Column(type="integer")
     */
    private $gorge;

    /**
     * @ORM\ManyToMany(targetEntity=Game::class, mappedBy="players")
     */
    private $games;

    /**
     * @ORM\Column(type="integer")
     */
    private $gorgee_total;

    /**
     * @ORM\Column(type="integer")
     */
    private $km_total;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $cities = [];

    public function __construct()
    {
        $this->games = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayer(): ?string
    {
        return $this->player;
    }

    public function setPlayer(string $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getKm(): ?int
    {
        return $this->km;
    }

    public function setKm(int $km): self
    {
        $this->km = $km;

        return $this;
    }

    public function getGorge(): ?int
    {
        return $this->gorge;
    }

    public function setGorge(int $gorge): self
    {
        $this->gorge = $gorge;

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
            $game->addPlayer($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->removeElement($game)) {
            $game->removePlayer($this);
        }

        return $this;
    }

    public function getGorgeeTotal(): ?int
    {
        return $this->gorgee_total;
    }

    public function setGorgeeTotal(int $gorgee_total): self
    {
        $this->gorgee_total = $gorgee_total;

        return $this;
    }

    public function getKmTotal(): ?int
    {
        return $this->km_total;
    }

    public function setKmTotal(int $km_total): self
    {
        $this->km_total = $km_total;

        return $this;
    }

    public function getCities(): ?array
    {
        return $this->cities;
    }

    public function setCities(?array $cities): self
    {
        $this->cities = $cities;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\ActionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActionRepository::class)]
class Action
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $difficulty = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?int $id_ship = null;

    #[ORM\Column(nullable: true)]
    private ?int $id_linked = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDifficulty(): ?string
    {
        return $this->difficulty;
    }

    public function setDifficulty(string $difficulty): static
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getIdShip(): ?int
    {
        return $this->id_ship;
    }

    public function setIdShip(int $id_ship): static
    {
        $this->id_ship = $id_ship;

        return $this;
    }

    public function getIdLinked(): ?int
    {
        return $this->id_linked;
    }

    public function setIdLinked(?int $id_linked): static
    {
        $this->id_linked = $id_linked;

        return $this;
    }
}

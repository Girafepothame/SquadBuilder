<?php

namespace App\Entity;

use App\Repository\StatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatRepository::class)]
class Stat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $arc = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $recovers = null;

    #[ORM\Column]
    private ?int $id_ship = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArc(): ?string
    {
        return $this->arc;
    }

    public function setArc(?string $arc): static
    {
        $this->arc = $arc;

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

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getRecovers(): ?string
    {
        return $this->recovers;
    }

    public function setRecovers(?string $recovers): static
    {
        $this->recovers = $recovers;

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
}

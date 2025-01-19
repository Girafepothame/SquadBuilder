<?php

namespace App\Entity;

use App\Repository\DialRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DialRepository::class)]
class Dial
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $dialCodes = null;

    #[ORM\Column]
    private ?int $id_ship = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDialCodes(): ?string
    {
        return $this->dialCodes;
    }

    public function setDialCodes(string $dialCodes): static
    {
        $this->dialCodes = $dialCodes;

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

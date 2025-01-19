<?php

namespace App\Entity;

use App\Repository\ManeuverRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ManeuverRepository::class)]
class Maneuver
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column]
    private ?int $id_dial = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getIdDial(): ?int
    {
        return $this->id_dial;
    }

    public function setIdDial(int $id_dial): static
    {
        $this->id_dial = $id_dial;

        return $this;
    }
}

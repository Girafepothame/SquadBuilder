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

    #[ORM\ManyToOne(targetEntity: Dial::class)]
    #[ORM\JoinColumn(name: 'id_dial', referencedColumnName: 'id')]
    private ?Dial $dial = null;

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

    public function getDial(): ?Dial
    {
        return $this->dial;
    }

    public function setDial(Dial $dial): static
    {
        $this->dial = $dial;

        return $this;
    }
}


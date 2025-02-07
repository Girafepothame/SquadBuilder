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

    // Utilisation de ManyToOne pour la relation avec Ship
    #[ORM\ManyToOne(targetEntity: Ship::class)]
    #[ORM\JoinColumn(name: "id_ship", referencedColumnName: "id")]
    private ?Ship $ship = null; // Référence à l'entité Ship


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

    // Méthodes pour accéder à la relation ManyToOne avec Ship
    public function getShip(): ?Ship
    {
        return $this->ship;
    }

    public function setShip(?Ship $ship): static
    {
        $this->ship = $ship;

        return $this;
    }
}


<?php

namespace App\Entity;

use App\Repository\SeatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeatRepository::class)]
class Seat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $seat_per_rows = null;

    #[ORM\Column]
    private ?int $lignes = null;

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

    public function getSeatPerRows(): ?int
    {
        return $this->seat_per_rows;
    }

    public function setSeatPerRows(int $seat_per_rows): self
    {
        $this->seat_per_rows = $seat_per_rows;

        return $this;
    }

    public function getLignes(): ?int
    {
        return $this->lignes;
    }

    public function setLignes(int $lignes): self
    {
        $this->lignes = $lignes;

        return $this;
    }
}

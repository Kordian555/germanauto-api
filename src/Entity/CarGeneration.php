<?php

namespace App\Entity;

use App\Repository\CarGenerationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: CarGenerationRepository::class)]
class CarGeneration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'carGenerations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CarModel $carmodel = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read'])]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read'])]
    private ?int $production_start = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read'])]
    private ?int $production_end = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCarmodel(): ?CarModel
    {
        return $this->carmodel;
    }

    public function setCarmodel(?CarModel $carmodel): static
    {
        $this->carmodel = $carmodel;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getProductionStart(): ?int
    {
        return $this->production_start;
    }

    public function setProductionStart(?int $production_start): static
    {
        $this->production_start = $production_start;

        return $this;
    }

    public function getProductionEnd(): ?int
    {
        return $this->production_end;
    }

    public function setProductionEnd(?int $production_end): static
    {
        $this->production_end = $production_end;

        return $this;
    }
}

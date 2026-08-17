<?php

namespace App\Entity;

use App\Repository\CarModelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: CarModelRepository::class)]
class CarModel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'carModels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CarBrand $carbrand = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read'])]
    private ?string $name = null;

    /**
     * @var Collection<int, CarGeneration>
     */
    #[ORM\OneToMany(targetEntity: CarGeneration::class, mappedBy: 'carmodel')]
    private Collection $carGenerations;

    /**
     * @var Collection<int, ListingCar>
     */
    #[ORM\OneToMany(targetEntity: ListingCar::class, mappedBy: 'car_model')]
    private Collection $listingCars;

    public function __construct()
    {
        $this->carGenerations = new ArrayCollection();
        $this->listingCars = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCarbrand(): ?CarBrand
    {
        return $this->carbrand;
    }

    public function setCarbrand(?CarBrand $carbrand): static
    {
        $this->carbrand = $carbrand;

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

    /**
     * @return Collection<int, CarGeneration>
     */
    public function getCarGenerations(): Collection
    {
        return $this->carGenerations;
    }

    public function addCarGeneration(CarGeneration $carGeneration): static
    {
        if (!$this->carGenerations->contains($carGeneration)) {
            $this->carGenerations->add($carGeneration);
            $carGeneration->setCarmodel($this);
        }

        return $this;
    }

    public function removeCarGeneration(CarGeneration $carGeneration): static
    {
        if ($this->carGenerations->removeElement($carGeneration)) {
            // set the owning side to null (unless already changed)
            if ($carGeneration->getCarmodel() === $this) {
                $carGeneration->setCarmodel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ListingCar>
     */
    public function getListingCars(): Collection
    {
        return $this->listingCars;
    }

    public function addListingCar(ListingCar $listingCar): static
    {
        if (!$this->listingCars->contains($listingCar)) {
            $this->listingCars->add($listingCar);
            $listingCar->setCarModel($this);
        }

        return $this;
    }

    public function removeListingCar(ListingCar $listingCar): static
    {
        if ($this->listingCars->removeElement($listingCar)) {
            // set the owning side to null (unless already changed)
            if ($listingCar->getCarModel() === $this) {
                $listingCar->setCarModel(null);
            }
        }

        return $this;
    }
}

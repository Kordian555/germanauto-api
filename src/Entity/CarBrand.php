<?php

namespace App\Entity;

use App\Repository\CarBrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: CarBrandRepository::class)]
class CarBrand
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read'])]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read'])]
    private ?array $score = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['read'])]
    private ?int $index_status = null;

    /**
     * @var Collection<int, CarModel>
     */
    #[ORM\OneToMany(targetEntity: CarModel::class, mappedBy: 'carbrand')]
    private Collection $carModels;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?bool $active = null;

    /**
     * @var Collection<int, ListingCar>
     */
    #[ORM\OneToMany(targetEntity: ListingCar::class, mappedBy: 'car_brand')]
    private Collection $listingCars;

    public function __construct()
    {
        $this->carModels = new ArrayCollection();
        $this->listingCars = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getScore(): ?array
    {
        return $this->score;
    }

    public function setScore(?array $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function getIndexStatus(): ?int
    {
        return $this->index_status;
    }

    public function setIndexStatus(int $index_status): static
    {
        $this->index_status = $index_status;

        return $this;
    }

    /**
     * @return Collection<int, CarModel>
     */
    public function getCarModels(): Collection
    {
        return $this->carModels;
    }

    public function addCarModel(CarModel $carModel): static
    {
        if (!$this->carModels->contains($carModel)) {
            $this->carModels->add($carModel);
            $carModel->setCarbrand($this);
        }

        return $this;
    }

    public function removeCarModel(CarModel $carModel): static
    {
        if ($this->carModels->removeElement($carModel)) {
            // set the owning side to null (unless already changed)
            if ($carModel->getCarbrand() === $this) {
                $carModel->setCarbrand(null);
            }
        }

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

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
            $listingCar->setCarBrand($this);
        }

        return $this;
    }

    public function removeListingCar(ListingCar $listingCar): static
    {
        if ($this->listingCars->removeElement($listingCar)) {
            // set the owning side to null (unless already changed)
            if ($listingCar->getCarBrand() === $this) {
                $listingCar->setCarBrand(null);
            }
        }

        return $this;
    }
}

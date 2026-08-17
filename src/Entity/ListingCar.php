<?php

namespace App\Entity;

use App\Repository\ListingCarRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListingCarRepository::class)]
class ListingCar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Listing $listing = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $mileage = null;

    #[ORM\Column(length: 255)]
    private ?string $mileage_unit = null;

    #[ORM\Column]
    private array $photos = [];

    #[ORM\Column(length: 255)]
    private ?string $fuel = null;

    #[ORM\Column(length: 255)]
    private ?string $gear = null;

    #[ORM\Column(length: 255)]
    private ?string $body_type = null;

    #[ORM\Column]
    private ?float $engine_size = null;

    #[ORM\Column(nullable: true)]
    private ?int $hp = null;

    #[ORM\Column(nullable: true)]
    private ?int $nm = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $color = null;

    #[ORM\Column]
    private ?int $production_year = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $vin = null;

    #[ORM\Column(length: 255)]
    private ?string $vehicle_condition = null;

    #[ORM\Column(length: 255)]
    private ?string $damage_status = null;

    #[ORM\Column(length: 255)]
    private ?string $drive = null;

    #[ORM\Column(nullable: true)]
    private ?float $fuel_ussage = null;

    #[ORM\Column(nullable: true)]
    private ?float $fuel_ussage_city = null;

    #[ORM\Column(nullable: true)]
    private ?array $extras = null;

    #[ORM\ManyToOne(inversedBy: 'listingCars')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CarBrand $car_brand = null;

    #[ORM\ManyToOne(inversedBy: 'listingCars')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CarModel $car_model = null;

    #[ORM\ManyToOne(inversedBy: 'listingCars')]
    private ?CarGeneration $car_generation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getListing(): ?Listing
    {
        return $this->listing;
    }

    public function setListing(Listing $listing): static
    {
        $this->listing = $listing;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getMileage(): ?float
    {
        return $this->mileage;
    }

    public function setMileage(float $mileage): static
    {
        $this->mileage = $mileage;

        return $this;
    }

    public function getMileageUnit(): ?string
    {
        return $this->mileage_unit;
    }

    public function setMileageUnit(string $mileage_unit): static
    {
        $this->mileage_unit = $mileage_unit;

        return $this;
    }

    public function getPhotos(): array
    {
        return $this->photos;
    }

    public function setPhotos(array $photos): static
    {
        $this->photos = $photos;

        return $this;
    }

    public function getFuel(): ?string
    {
        return $this->fuel;
    }

    public function setFuel(string $fuel): static
    {
        $this->fuel = $fuel;

        return $this;
    }

    public function getGear(): ?string
    {
        return $this->gear;
    }

    public function setGear(string $gear): static
    {
        $this->gear = $gear;

        return $this;
    }

    public function getBodyType(): ?string
    {
        return $this->body_type;
    }

    public function setBodyType(string $body_type): static
    {
        $this->body_type = $body_type;

        return $this;
    }

    public function getEngineSize(): ?float
    {
        return $this->engine_size;
    }

    public function setEngineSize(float $engine_size): static
    {
        $this->engine_size = $engine_size;

        return $this;
    }

    public function getHp(): ?int
    {
        return $this->hp;
    }

    public function setHp(?int $hp): static
    {
        $this->hp = $hp;

        return $this;
    }

    public function getNm(): ?int
    {
        return $this->nm;
    }

    public function setNm(?int $nm): static
    {
        $this->nm = $nm;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getProductionYear(): ?int
    {
        return $this->production_year;
    }

    public function setProductionYear(int $production_year): static
    {
        $this->production_year = $production_year;

        return $this;
    }

    public function getVin(): ?string
    {
        return $this->vin;
    }

    public function setVin(?string $vin): static
    {
        $this->vin = $vin;

        return $this;
    }

    public function getVehicleCondition(): ?string
    {
        return $this->vehicle_condition;
    }

    public function setVehicleCondition(string $vechicle_condition): static
    {
        $this->vehicle_condition = $vechicle_condition;

        return $this;
    }

    public function getDamageStatus(): ?string
    {
        return $this->damage_status;
    }

    public function setDamageStatus(string $damage_status): static
    {
        $this->damage_status = $damage_status;

        return $this;
    }

    public function getDrive(): ?string
    {
        return $this->drive;
    }

    public function setDrive(string $drive): static
    {
        $this->drive = $drive;

        return $this;
    }

    public function getFuelUssage(): ?float
    {
        return $this->fuel_ussage;
    }

    public function setFuelUssage(?float $fuel_ussage): static
    {
        $this->fuel_ussage = $fuel_ussage;

        return $this;
    }

    public function getFuelUssageCity(): ?float
    {
        return $this->fuel_ussage_city;
    }

    public function setFuelUssageCity(?float $fuel_ussage_city): static
    {
        $this->fuel_ussage_city = $fuel_ussage_city;

        return $this;
    }

    public function getExtras(): ?array
    {
        return $this->extras;
    }

    public function setExtras(?array $extras): static
    {
        $this->extras = $extras;

        return $this;
    }

    public function getCarBrand(): ?CarBrand
    {
        return $this->car_brand;
    }

    public function setCarBrand(?CarBrand $car_brand): static
    {
        $this->car_brand = $car_brand;

        return $this;
    }

    public function getCarModel(): ?CarModel
    {
        return $this->car_model;
    }

    public function setCarModel(?CarModel $car_model): static
    {
        $this->car_model = $car_model;

        return $this;
    }

    public function getCarGeneration(): ?CarGeneration
    {
        return $this->car_generation;
    }

    public function setCarGeneration(?CarGeneration $car_generation): static
    {
        $this->car_generation = $car_generation;

        return $this;
    }
}

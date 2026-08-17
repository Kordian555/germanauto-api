<?php

namespace App\Entity;

use App\Repository\ListingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListingRepository::class)]
class Listing
{
    const LISTING_TYPE_CAR = 'car';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $add_date = null;

    #[ORM\Column(nullable: true)]
    private ?int $modification_date = null;

    #[ORM\Column(nullable: true)]
    private ?int $delete_date = null;

    #[ORM\ManyToOne(inversedBy: 'listings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $status = null;

    #[ORM\Column]
    private ?int $index_status = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length: 255)]
    private ?string $currency = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddDate(): ?int
    {
        return $this->add_date;
    }

    public function setAddDate(int $add_date): static
    {
        $this->add_date = $add_date;

        return $this;
    }

    public function getModificationDate(): ?int
    {
        return $this->modification_date;
    }

    public function setModificationDate(?int $modification_date): static
    {
        $this->modification_date = $modification_date;

        return $this;
    }

    public function getDeleteDate(): ?int
    {
        return $this->delete_date;
    }

    public function setDeleteDate(?int $delete_date): static
    {
        $this->delete_date = $delete_date;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }
}

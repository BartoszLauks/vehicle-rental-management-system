<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Assert\Unique()]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $registrationNumber = null;

    #[ORM\Column]
    private ?DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?DateTimeImmutable $updated_at = null;

    #[ORM\Column]
    private ?int $mileage = null;

    #[ORM\ManyToOne(inversedBy: 'vehicle')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Brand $brand = null;

    #[ORM\ManyToOne(inversedBy: 'vehicle')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Depot $depot = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $daily_price = null;

    #[ORM\Column]
    private ?int $mileage_limit_per_day = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $additional_km_cost = null;

    /**
     * @var Collection<int, Booking>
     */
    #[ORM\OneToMany(targetEntity: Booking::class, mappedBy: 'vehicle')]
    private Collection $bookings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
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

    public function getRegistrationNumber(): ?string
    {
        return $this->registrationNumber;
    }

    public function setRegistrationNumber(string $registrationNumber): static
    {
        $this->registrationNumber = $registrationNumber;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getMileage(): ?int
    {
        return $this->mileage;
    }

    public function setMileage(int $mileage): static
    {
        $this->mileage = $mileage;

        return $this;
    }

    #[ORM\PrePersist()]
    #[ORM\PreUpdate()]
    public function updateTimestamps(): void
    {
        $this->updated_at = new DateTimeImmutable('now');

        if (! isset($this->created_at)) {
            $this->created_at = new DateTimeImmutable('now');
        }
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getDepot(): ?Depot
    {
        return $this->depot;
    }

    public function setDepot(?Depot $depot): static
    {
        $this->depot = $depot;

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): static
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setVehicle($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getVehicle() === $this) {
                $booking->setVehicle(null);
            }
        }

        return $this;
    }

    public function getDailyPrice(): ?string
    {
        return $this->daily_price;
    }

    public function setDailyPrice(string $daily_price): static
    {
        $this->daily_price = $daily_price;

        return $this;
    }

    public function getMileageLimitPerday(): ?int
    {
        return $this->mileage_limit_per_day;
    }

    public function setMileageLimitPerday(int $mileage_limit_per_day): static
    {
        $this->mileage_limit_per_day = $mileage_limit_per_day;

        return $this;
    }

    public function getAdditionalKmCost(): ?string
    {
        return $this->additional_km_cost;
    }

    public function setAdditionalKmCost(string $additional_km_cost): static
    {
        $this->additional_km_cost = $additional_km_cost;

        return $this;
    }
}

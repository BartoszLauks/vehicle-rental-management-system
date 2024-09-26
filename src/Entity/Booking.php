<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vehicle $vehicle = null;

    /**
     * @var Collection<int, BookingStatus>
     */
    #[ORM\OneToMany(targetEntity: BookingStatus::class, mappedBy: 'booking')]
    private Collection $status;

    #[ORM\Column]
    private ?DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?DateTimeImmutable $updated_at = null;

    /**
     * @var Collection<int, Payments>
     */
    #[ORM\OneToMany(targetEntity: Payments::class, mappedBy: 'booking')]
    private Collection $payments;

    #[ORM\Column]
    private ?DateTimeImmutable $start_date = null;

    #[ORM\Column]
    private ?DateTimeImmutable $end_date = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $delivery_time = null;

    #[ORM\Column(nullable: true)]
    private ?int $total_km = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $base_cost = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $additional_km_cost = null;

    #[ORM\ManyToOne]
    private ?Discounts $discount = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $discount_amount = null;

    #[ORM\ManyToOne]
    private ?Promotions $promotion = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $promotion_amount = null;

    public function __construct()
    {
        $this->status = new ArrayCollection();
        $this->payments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): static
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    /**
     * @return Collection<int, BookingStatus>
     */
    public function getStatus(): Collection
    {
        return $this->status;
    }

    public function addStatus(BookingStatus $status): static
    {
        if (!$this->status->contains($status)) {
            $this->status->add($status);
            $status->setBooking($this);
        }

        return $this;
    }

    public function removeStatus(BookingStatus $status): static
    {
        if ($this->status->removeElement($status)) {
            // set the owning side to null (unless already changed)
            if ($status->getBooking() === $this) {
                $status->setBooking(null);
            }
        }

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

    #[ORM\PrePersist()]
    #[ORM\PreUpdate()]
    public function updateTimestamps(): void
    {
        $this->updated_at = new DateTimeImmutable('now');

        if (! isset($this->created_at)) {
            $this->created_at = new DateTimeImmutable('now');
        }
    }

    /**
     * @return Collection<int, Payments>
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payments $payment): static
    {
        if (!$this->payments->contains($payment)) {
            $this->payments->add($payment);
            $payment->setBooking($this);
        }

        return $this;
    }

    public function removePayment(Payments $payment): static
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getBooking() === $this) {
                $payment->setBooking(null);
            }
        }

        return $this;
    }

    public function getStartDate(): ?DateTimeImmutable
    {
        return $this->start_date;
    }

    public function setStartDate(DateTimeImmutable $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?DateTimeImmutable
    {
        return $this->end_date;
    }

    public function setEndDate(DateTimeImmutable $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getDeliveryTime(): ?DateTimeImmutable
    {
        return $this->delivery_time;
    }

    public function setDeliveryTime(?DateTimeImmutable $delivery_time): static
    {
        $this->delivery_time = $delivery_time;

        return $this;
    }

    public function getTotalKm(): ?int
    {
        return $this->total_km;
    }

    public function setTotalKm(?int $total_km): static
    {
        $this->total_km = $total_km;

        return $this;
    }

    public function getBaseCost(): ?string
    {
        return $this->base_cost;
    }

    public function setBaseCost(string $base_cost): static
    {
        $this->base_cost = $base_cost;

        return $this;
    }

    public function getAdditionalKmCost(): ?string
    {
        return $this->additional_km_cost;
    }

    public function setAdditionalKmCost(?string $additional_km_cost): static
    {
        $this->additional_km_cost = $additional_km_cost;

        return $this;
    }

    public function getDiscount(): ?Discounts
    {
        return $this->discount;
    }

    public function setDiscount(?Discounts $discount): static
    {
        $this->discount = $discount;

        return $this;
    }

    public function getDiscountAmount(): ?string
    {
        return $this->discount_amount;
    }

    public function setDiscountAmount(?string $discount_amount): static
    {
        $this->discount_amount = $discount_amount;

        return $this;
    }

    public function getPromotion(): ?Promotions
    {
        return $this->promotion;
    }

    public function setPromotion(?Promotions $promotion): static
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function getPromotionAmount(): ?string
    {
        return $this->promotion_amount;
    }

    public function setPromotionAmount(string $promotion_amount): static
    {
        $this->promotion_amount = $promotion_amount;

        return $this;
    }
}

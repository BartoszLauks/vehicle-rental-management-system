<?php

namespace App\Entity;

use App\Enum\BookingStatus as BookingStatusEnum;
use App\Repository\BookingStatusRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: BookingStatusRepository::class)]
class BookingStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: BookingStatusEnum::class)]
    private BookingStatusEnum $status = BookingStatusEnum::ORDERED;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'status')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Booking $booking = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): BookingStatusEnum
    {
        return $this->status;
    }

    public function setStatus(BookingStatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

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

    public function getBooking(): ?Booking
    {
        return $this->booking;
    }

    public function setBooking(?Booking $booking): static
    {
        $this->booking = $booking;

        return $this;
    }
}

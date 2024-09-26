<?php

namespace App\Entity;

use App\Enum\StripePaymentStatus;
use App\Repository\PaymentsRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentsRepository::class)]
class Payments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: StripePaymentStatus::class)]
    private StripePaymentStatus $status = StripePaymentStatus::PENDING;

    #[ORM\Column]
    private ?DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?DateTimeImmutable $updated_at = null;

    #[ORM\Column(length: 255)]
    private ?string $idSession = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $url = null;

    #[ORM\Column]
    private ?int $sessionCreatedTimestamp = null;

    #[ORM\Column]
    private ?int $sessionExpiresAtTimestamp = null;

    #[ORM\Column(length: 3)]
    private ?string $currency = null;

    #[ORM\Column]
    private ?int $amount_total = null;

    #[ORM\Column(nullable: true)]
    private ?array $metadata = null;

    #[ORM\ManyToOne(inversedBy: 'payments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Booking $booking = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?StripePaymentStatus
    {
        return $this->status;
    }

    public function setStatus(StripePaymentStatus $status): static
    {
        $this->status = $status;

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

    public function getIdSession(): ?string
    {
        return $this->idSession;
    }

    public function setIdSession(string $idSession): static
    {
        $this->idSession = $idSession;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getSessionCreatedTimestamp(): ?int
    {
        return $this->sessionCreatedTimestamp;
    }

    public function setSessionCreatedTimestamp(int $sessionCreatedTimestamp): static
    {
        $this->sessionCreatedTimestamp = $sessionCreatedTimestamp;

        return $this;
    }

    public function getSessionExpiresAtTimestamp(): ?int
    {
        return $this->sessionExpiresAtTimestamp;
    }

    public function setSessionExpiresAtTimestamp(int $sessionExpiresAtTimestamp): static
    {
        $this->sessionExpiresAtTimestamp = $sessionExpiresAtTimestamp;

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

    public function getAmountTotal(): ?int
    {
        return $this->amount_total;
    }

    public function setAmountTotal(int $amount_total): static
    {
        $this->amount_total = $amount_total;

        return $this;
    }

    public function getMetadata(): ?array
    {
        return $this->metadata;
    }

    public function setMetadata(?array $metadata): static
    {
        $this->metadata = $metadata;

        return $this;
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

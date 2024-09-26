<?php

namespace App\Entity;

use App\Enum\DiscountsEnum;
use App\Repository\PromotionsRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PromotionsRepository::class)]
class Promotions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column(enumType: DiscountsEnum::class)]
    private ?DiscountsEnum $type = null;

    #[ORM\Column]
    private ?int $value = null;

    #[ORM\Column]
    #[Assert\LessThan(propertyPath: 'valid_to')]
    private ?DateTimeImmutable $valid_from = null;

    #[ORM\Column]
    #[Assert\GreaterThan(propertyPath: 'valid_from')]
    private ?DateTimeImmutable $valid_to = null;

    #[ORM\Column]
    private ?bool $active = true;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getType(): ?DiscountsEnum
    {
        return $this->type;
    }

    public function setType(DiscountsEnum $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getValidFrom(): ?DateTimeImmutable
    {
        return $this->valid_from;
    }

    public function setValidFrom(DateTimeImmutable $valid_from): static
    {
        $this->valid_from = $valid_from;

        return $this;
    }

    public function getValidTo(): ?DateTimeImmutable
    {
        return $this->valid_to;
    }

    public function setValidTo(DateTimeImmutable $valid_to): static
    {
        $this->valid_to = $valid_to;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }
}

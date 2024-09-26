<?php

namespace App\Entity;

use App\Enum\DiscountsEnum;
use App\Repository\DiscountsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiscountsRepository::class)]
class Discounts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(enumType: DiscountsEnum::class)]
    private ?DiscountsEnum $type = null;

    #[ORM\Column]
    private ?int $value = null;

    #[ORM\Column]
    private ?int $minimum_days = null;

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

    public function getMinimumDays(): ?int
    {
        return $this->minimum_days;
    }

    public function setMinimumDays(int $minimum_days): static
    {
        $this->minimum_days = $minimum_days;

        return $this;
    }
}

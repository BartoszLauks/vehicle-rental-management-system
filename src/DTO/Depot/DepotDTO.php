<?php

declare(strict_types=1);

namespace App\DTO\Depot;

use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as Validator;

final class DepotDTO
{
    /** @param mixed[]|null $depotData */
    public function __construct(?array $depotData)
    {
        $this->name = $depotData['name'] ?? null;
        $this->city = $depotData['city'] ?? null;
        $this->postalCode = $depotData['postalCode '] ?? null;
        $this->street = $depotData['street'] ?? null;
        $this->number = $depotData['number'] ?? null;
        $this->phone = $depotData['phone'] ?? null;
        $this->emailContact = $depotData['emailContact'] ?? null;
        $this->longitude = $depotData['longitude'] ?? null;
        $this->latitude = $depotData['latitude'] ?? null;
    }

    #[Groups(groups: ['depot:default'])]
    #[Assert\NotBlank(groups: ['depot:default'])]
    #[Validator\DepotNameExist(reverse: true, groups: ['depot:default'])]
    public ?string $name;

    #[Groups(groups: ['depot:default'])]
    #[Assert\NotBlank(groups: ['depot:default'])]
    public ?string $city;

    #[Groups(groups: ['depot:default'])]
    #[Assert\NotBlank(groups: ['depot:default'])]
    public ?string $postalCode;

    #[Groups(groups: ['depot:default'])]
    #[Assert\NotBlank(groups: ['depot:default'])]
    public ?string $street;

    #[Groups(groups: ['depot:default'])]
    #[Assert\NotBlank(groups: ['depot:default'])]
    public ?string $number;

    #[Groups(groups: ['depot:default'])]
    #[Assert\NotBlank(groups: ['depot:default'])]
    public ?string $phone;

    #[Groups(groups: ['depot:default'])]
    #[Assert\NotBlank(groups: ['depot:default'])]
    public ?string $emailContact;

    #[Groups(groups: ['depot:default'])]
    public ?float $longitude;

    #[Groups(groups: ['depot:default'])]
    public ?float $latitude;
}

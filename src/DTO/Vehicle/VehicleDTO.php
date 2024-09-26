<?php

namespace App\DTO\Vehicle;

use App\Entity\Vehicle;
use App\Validator as Validator;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(fields: 'name', entityClass: Vehicle::class, groups: ['vehicle:default'])]
#[UniqueEntity(fields: 'registrationNumber', entityClass: Vehicle::class, groups: ['vehicle:default'], identifierFieldNames: )]
final class VehicleDTO
{
    /** @param mixed[]|null $vehicleData */
    public function __construct(?array $vehicleData)
    {
        $this->name = $vehicleData['email'] ?? null;
        $this->registrationNumber = $vehicleData['registrationNumber'] ?? null;
        $this->mileage = $vehicleData['mileage'] ?? 0;
        $this->brand_name = $vehicleData['brand_name'] ?? null;
        $this->daily_price = $vehicleData['daily_price'] ?? null;
        $this->mileage_limit_per_day = $vehicleData['mileage_limit_per_day'] ?? null;
        $this->additional_km_cost = $vehicleData['additional_km_cost'] ?? null;
    }

    #[Groups(groups: ['vehicle:default'])]
    #[Assert\NotBlank(groups: ['vehicle:default'])]
    public ?string $name;

    #[Groups(groups: ['vehicle:default'])]
    #[Assert\NotBlank(groups: ['vehicle:default'])]
    public ?string $registrationNumber;

    #[Groups(groups: ['vehicle:default'])]
    #[Assert\NotBlank(groups: ['vehicle:default'])]
    #[Assert\PositiveOrZero(groups: ['vehicle:default'])]
    public ?int $mileage;

    #[Groups(groups: ['vehicle:default'])]
    #[Assert\NotBlank(groups: ['vehicle:default'])]
    #[Validator\BrandNameExists(groups: ['vehicle:default', 'vehicle:patch'], reverse: true)]
    public ?string $brand_name;

    #[Groups(groups: ['vehicle:default'])]
    #[Assert\NotBlank(groups: ['vehicle:default'])]
    #[Validator\DepotNameExist(groups: ['vehicle:default'])]
    public ?string $depot_name;

    #[Groups(groups: ['vehicle:default'])]
    #[Assert\NotBlank(groups: ['vehicle:default'])]
    #[Assert\Regex('/^\d+(\.\d+)?$/', groups: ['vehicle:default'])]
    public ?string $daily_price;
    #[Groups(groups: ['vehicle:default'])]
    #[Assert\NotBlank(groups: ['vehicle:default'])]
    #[Assert\Positive(groups: ['vehicle:default'])]
    public ?int $mileage_limit_per_day;
    #[Groups(groups: ['vehicle:default'])]
    #[Assert\NotBlank(groups: ['vehicle:default'])]
    #[Assert\Regex('/^\d+(\.\d+)?$/', groups: ['vehicle:default'])]
    public ?string $additional_km_cost;
}
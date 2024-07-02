<?php

namespace App\DTO\Vehicle;

use App\Validator as Validator;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class VehicleDTO
{
    /** @param mixed[]|null $vehicleData */
    public function __construct(?array $vehicleData)
    {
        $this->name = $vehicleData['email'] ?? null;
        $this->registrationNumber = $vehicleData['registrationNumber'] ?? null;
        $this->mileage = $vehicleData['mileage'] ?? 0;
        $this->brand_name = $vehicleData['brand_name'] ?? null;
    }

    #[Groups(groups: ['vehicle:default'])]
    #[Assert\NotBlank(groups: ['vehicle:default'])]
    public ?string $name;

    #[Groups(groups: ['vehicle:default'])]
    #[Assert\NotBlank(groups: ['vehicle:default'])]
    public ?string $registrationNumber;

    #[Groups(groups: ['vehicle:default'])]
    #[Assert\NotBlank(groups: ['vehicle:default'])]
    public ?int $mileage;

    #[Groups(groups: ['vehicle:default'])]
    #[Assert\NotBlank(groups: ['vehicle:default', 'vehicle:patch'])]
    #[Validator\BrandNameExists(groups: ['vehicle:default', 'vehicle:patch'])]
    public ?string $brand_name;

}
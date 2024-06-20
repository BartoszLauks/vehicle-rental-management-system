<?php

namespace App\DTO\Vehicle;

use App\Validator as Validator;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class VehicleDTO
{
    public function __construct(?array $vehicleData)
    {
        $this->name = $vehicleData['email'] ?? null;
        $this->registrationNumber = $vehicleData['registrationNumber'] ?? null;
        $this->mileage = $vehicleData['mileage'] ?? 0;
        $this->brand_name = $vehicleData['brand_name'] ?? null;
    }

    #[Groups(groups: ['vehicle:create'])]
    #[Assert\NotBlank(groups: ['vehicle:create'])]
    public ?string $name;

    #[Groups(groups: ['vehicle:create'])]
    #[Assert\NotBlank(groups: ['vehicle:create'])]
    public ?string $registrationNumber;

    #[Groups(groups: ['vehicle:create'])]
    #[Assert\NotBlank(groups: ['vehicle:create'])]
    public ?int $mileage;

    #[Groups(groups: ['vehicle:create'])]
    #[Validator\BrandNameExists(groups: ['vehicle:create'])]
    public ?string $brand_name;

}
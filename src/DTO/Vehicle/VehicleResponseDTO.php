<?php

namespace App\DTO\Vehicle;

use App\DTO\Brand\BrandResponseDTO;
use Symfony\Component\Serializer\Attribute\Groups;

class VehicleResponseDTO
{
    #[Groups(['vehicle:default'])]
    public int $id;
    #[Groups(['vehicle:default'])]
    public string $name;
    #[Groups(['vehicle:default'])]
    public string $registrationNumber;
    #[Groups(['vehicle:default'])]
    public string $createdAt;
    #[Groups(['vehicle:default'])]
    public string $updatedAt;
    #[Groups(['vehicle:default'])]
    public int $mileage;
    #[Groups(['vehicle:default'])]
    public BrandResponseDTO $brand;

}
<?php

namespace App\DTO\Vehicle;

use App\DTO\Brand\BrandResponseDTO;

class VehicleResponseDTO
{
    public int $id;

    public string $name;

    public string $registrationNumber;

    public string $createdAt;
    public string $updatedAt;
    public int $mileage;

    public BrandResponseDTO $brand;

}
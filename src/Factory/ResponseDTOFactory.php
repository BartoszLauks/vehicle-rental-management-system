<?php

namespace App\Factory;

use App\DTO\Brand\BrandResponseDTO;
use App\DTO\User\UserResponseDTO;
use App\DTO\Vehicle\VehicleResponseDTO;
use App\Entity\Brand;
use App\Entity\User;
use App\Entity\Vehicle;

class ResponseDTOFactory
{
    public function createVehicleDTOFromVehicle(Vehicle $vehicle): VehicleResponseDTO
    {
        $dto = new VehicleResponseDTO();

        $dto->id = $vehicle->getId();
        $dto->name = $vehicle->getName();
        $dto->registrationNumber = $vehicle->getRegistrationNumber();
        $dto->createdAt = $vehicle->getCreatedAt()->format('Y-m-d');
        $dto->updatedAt = $vehicle->getUpdatedAt()->format('Y-m-d');
        $dto->mileage = $vehicle->getMileage();
        $dto->brand = $this->createBrandDTOFromVehicle($vehicle->getBrand());

        return $dto;
    }

    public function createUserDTOFromVehicle(User $user): UserResponseDTO
    {
        $dto = new UserResponseDTO();

        $dto->id = $user->getId();
        $dto->email = $user->getEmail();
        $dto->roles = $user->getRoles();

        return $dto;
    }

    public function createBrandDTOFromVehicle(Brand $brand): BrandResponseDTO
    {
        $dto = new BrandResponseDTO();

        $dto->id = $brand->getId();
        $dto->name = $brand->getName();

        return $dto;
    }
}
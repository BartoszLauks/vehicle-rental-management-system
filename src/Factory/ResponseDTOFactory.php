<?php

namespace App\Factory;

use App\DTO\Brand\BrandResponseDTO;
use App\DTO\Depot\DepotResponseDTO;
use App\DTO\Promotions\PromotionsResponseDTO;
use App\DTO\User\UserResponseDTO;
use App\DTO\Vehicle\VehicleResponseDTO;
use App\Entity\Brand;
use App\Entity\Depot;
use App\Entity\Promotions;
use App\Entity\User;
use App\Entity\Vehicle;

class ResponseDTOFactory
{
    public function createDepotDTOFromDepot(Depot $depot): DepotResponseDTO
    {
        $dto = new DepotResponseDTO();

        $dto->id = $depot->getId();
        $dto->name = $depot->getName();
        $dto->city = $depot->getCity();
        $dto->postalCode = $depot->getPostalCode();
        $dto->street = $depot->getStreet();
        $dto->number = $depot->getNumber();
        $dto->phone = $depot->getPhone();
        $dto->emailContact = $depot->getEmailContact();
        $dto->longitude = $depot->getLongitude();
        $dto->latitude = $depot->getLatitude();

        return $dto;
    }

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

    public function createPromotionsDTOFromVehicle(Promotions $promotions): PromotionsResponseDTO
    {
        $dto = new PromotionsResponseDTO();

        $dto->id = $promotions->getId();
        $dto->code = $promotions->getCode();
        $dto->type = $promotions->getType()->value;
        $dto->value = $promotions->getValue();
        $dto->valid_from = $promotions->getValidFrom()->format('Y-m-d H:i:s');
        $dto->valid_to = $promotions->getValidTo()->format('Y-m-d H:i:s');
        $dto->active = $promotions->getActive();

        return $dto;
    }
}
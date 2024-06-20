<?php

namespace App\Factory;

use App\DTO\Vehicle\VehicleDTO;
use App\Entity\Vehicle;
use App\Repository\BrandRepository;

final readonly class VehicleFactory
{
    public function __construct(
        private BrandRepository $brandRepository,
    ) {

    }

    public function createFromDTO(VehicleDTO $vehicleDTO): Vehicle
    {
        $vehicle = new Vehicle();

        $vehicle->setName($vehicleDTO->name);
        $vehicle->setRegistrationNumber($vehicleDTO->registrationNumber);
        $vehicle->setMileage($vehicleDTO->mileage);

        $vehicle->setBrand($this->brandRepository->findOneBy(['name' => $vehicleDTO->brand_name]));

        return $vehicle;
    }
}
<?php

namespace App\Factory;

use App\DTO\Vehicle\VehicleDTO;
use App\Entity\Vehicle;
use App\Repository\BrandRepository;
use App\Repository\DepotRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

final readonly class VehicleFactory
{
    public function __construct(
        private BrandRepository $brandRepository,
        private DepotRepository $depotRepository,
    ) {

    }

    public function createFromDTO(VehicleDTO $vehicleDTO): Vehicle
    {
        $vehicle = new Vehicle();

        $vehicle->setName($vehicleDTO->name);
        $vehicle->setRegistrationNumber($vehicleDTO->registrationNumber);
        $vehicle->setMileage($vehicleDTO->mileage);
        $vehicle->setDepot($this->depotRepository->findOneBy(['name' => $vehicleDTO->depot_name]));
        $vehicle->setBrand($this->brandRepository->findOneBy(['name' => $vehicleDTO->brand_name]));

        return $vehicle;
    }
}
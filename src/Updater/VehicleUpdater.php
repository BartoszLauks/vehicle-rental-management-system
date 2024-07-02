<?php

namespace App\Updater;

use App\DTO\Vehicle\VehicleDTO;
use App\Entity\Vehicle;
use App\Repository\BrandRepository;

class VehicleUpdater extends AbstractUpdater
{
    public function __construct(
        private readonly BrandRepository $brandRepository
    ) {
    }

    public function patch(Vehicle $vehicle, VehicleDTO $vehicleDTO): void
    {
        $this->updateField($vehicle, $vehicleDTO->name, 'getName', 'setName');
        $this->updateField($vehicle, $vehicleDTO->registrationNumber, 'getRegistrationNumber', 'setRegistrationNumber');
        $this->updateField($vehicle, $vehicleDTO->mileage, 'getMileage', 'setMileage');

        $this->updateBrandByName($vehicle, $vehicleDTO->brand_name);
    }

    private function updateBrandByName(Vehicle $vehicle, string $brandName): void
    {
        if ($brandName && $brandName !== $vehicle->getBrand()->getName()) {
            $brand = $this->brandRepository->findOneBy(['name' => $brandName]);
            $vehicle->setBrand($brand);
        }
    }
}

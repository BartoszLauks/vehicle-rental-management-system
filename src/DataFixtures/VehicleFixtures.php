<?php

namespace App\DataFixtures;

use App\Entity\Vehicle;
use App\Repository\BrandRepository;
use App\Repository\DepotRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VehicleFixtures extends Fixture
{
    public function __construct(
        private readonly BrandRepository $brandRepository,
        private readonly DepotRepository $depotRepository,
    ) {
    }

    private const int VEHICLE_QUANTITY = 10;

    /** @return array<string> */
    public static function getGroups(): array
    {
        return ['vehicle'];
    }

    public function load(ObjectManager $manager): void
    {
        $brand = $this->brandRepository->find(1);
        $depot = $this->depotRepository->find(1);

        for ($i = 1; $i < self::VEHICLE_QUANTITY; $i++) {
            $vehicle = new Vehicle();
            $vehicle->setName(sprintf('Vehicle%d',$i));
            $vehicle->setMileage(1000);
            $vehicle->setRegistrationNumber(sprintf('ABC %d', $i));
            $vehicle->setBrand($brand);
            $vehicle->setDepot($depot);
            $vehicle->setDailyPrice(sprintf('%s.00', 100 * $i));
            $vehicle->setMileageLimitPerday(sprintf('%s.00', 100 * $i));
            $vehicle->setAdditionalKmCost(sprintf('%s.00', 100 * $i));
            $manager->persist($vehicle);
        }

        $manager->flush();
    }

    /** @return array<string> */
    public function getDependencies(): array
    {
        return [
            BrandFixtures::class,
            DepotFixtures::class
        ];
    }
}

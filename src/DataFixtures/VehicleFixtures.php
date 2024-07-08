<?php

namespace App\DataFixtures;

use App\Entity\Vehicle;
use App\Repository\BrandRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VehicleFixtures extends Fixture
{
    public function __construct(
        private readonly BrandRepository $brandRepository,
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

        for ($i = 1; $i < self::VEHICLE_QUANTITY; $i++) {
            $vehicle = new Vehicle();
            $vehicle->setName(sprintf('Vehicle%d',$i));
            $vehicle->setMileage(1000);
            $vehicle->setRegistrationNumber(sprintf('ABC %d', $i));
            $vehicle->setBrand($brand);

            $manager->persist($vehicle);
        }

        $manager->flush();
    }

    /** @return array<string> */
    public function getDependencies(): array
    {
        return [
            BrandFixtures::class
        ];
    }
}

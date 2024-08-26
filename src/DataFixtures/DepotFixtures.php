<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Depot;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DepotFixtures extends Fixture
{
    private const int DEPOT_QUANTITY = 3;

    /** @return array<string> */
    public static function getGroups(): array
    {
        return ['depot'];
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < self::DEPOT_QUANTITY; $i++) {
            $depot = new Depot();
            $depot->setName(sprintf('Depot%d', $i));
            $depot->setCity(sprintf('City%d', $i));
            $depot->setPostalCode(sprintf('12-%d', $i));
            $depot->setStreet(sprintf('Street%s', $i));
            $depot->setNumber(sprintf('%d', $i));
            $depot->setPhone(sprintf('+1 123-123-12%d', $i));
            $depot->setEmailContact(sprintf('email%d@test.com', $i));
            $depot->setLongitude($i);
            $depot->setLatitude($i);

            $manager->persist($depot);
        }
        $manager->flush();
    }

    /** @return array<string> */
    public function getDependencies(): array
    {
        return [];
    }
}

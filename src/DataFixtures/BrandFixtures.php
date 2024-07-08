<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BrandFixtures extends Fixture
{
    private const int BRAND_QUANTITY = 3;

    /** @return array<string> */
    public static function getGroups(): array
    {
        return ['brand'];
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < self::BRAND_QUANTITY; $i++) {
            $brand = new Brand();
            $brand->setName(sprintf('Brand%d', $i));

            $manager->persist($brand);
        }
        $manager->flush();
    }

    /** @return array<string> */
    public function getDependencies(): array
    {
        return [];
    }
}

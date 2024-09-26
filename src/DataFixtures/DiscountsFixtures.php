<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Discounts;
use App\Enum\DiscountsEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DiscountsFixtures extends Fixture
{
    public static function getGroups(): array
    {
        return ['discounts'];
    }

    public function load(ObjectManager $manager): void
    {
        $month = new Discounts();
        $halfYear = new Discounts();
        $year = new Discounts();

        $month->setName('Discounts for month rental');
        $month->setType(DiscountsEnum::FIXED);
        $month->setValue(100);
        $month->setMinimumDays(30);
        $manager->persist($month);

        $halfYear->setName('Discounts for half a year rental');
        $halfYear->setType(DiscountsEnum::PERCENTAGE);
        $halfYear->setValue(10);
        $halfYear->setMinimumDays(182);
        $manager->persist($halfYear);

        $year->setName('Discounts for year rental');
        $year->setType(DiscountsEnum::PERCENTAGE);
        $year->setValue(20);
        $year->setMinimumDays(365);
        $manager->persist($year);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
          VehicleFixtures::class
        ];
    }
}
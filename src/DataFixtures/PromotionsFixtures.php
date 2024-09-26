<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Promotions;
use App\Enum\DiscountsEnum;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PromotionsFixtures extends Fixture
{
    public static function getGroups(): array
    {
        return ['promotions'];
    }

    private const int PROMOTIONS_QUANTITY = 3;

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < self::PROMOTIONS_QUANTITY; $i++) {
            $promotion = new Promotions();
            $promotion->setCode(sprintf('%s-%s-%s', 100 * $i, 100 * $i, 100 * $i));
            $promotion->setType(DiscountsEnum::FIXED);
            $promotion->setValue(100 * $i);
            $promotion->setValidFrom(new DateTimeImmutable('2000-01-01'));
            $promotion->setValidTo(new DateTimeImmutable('2100-01-01'));
            $manager->persist($promotion);
        }

        for ($i = 1; $i < self::PROMOTIONS_QUANTITY; $i++) {
            $promotion = new Promotions();
            $promotion->setCode(sprintf('%s-%s-%s', 10 * $i, 10 * $i, 10 * $i));
            $promotion->setType(DiscountsEnum::PERCENTAGE);
            $promotion->setValue(10 * $i);
            $promotion->setValidFrom(new DateTimeImmutable('2000-01-01'));
            $promotion->setValidTo(new DateTimeImmutable('2100-01-01'));
            $manager->persist($promotion);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            VehicleFixtures::class
        ];
    }
}
<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private const string PASSWORD = 'zaq1@WSXasdw';

    private const int USERS_QUANTITY = 10;

    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
    ) {
    }

    /** @return array<string> */
    public static function getGroups(): array
    {
        return ['user'];
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();

        $admin->setEmail('admin@test.com');
        $admin->setPassword($this->userPasswordHasher->hashPassword($admin, self::PASSWORD));
        $admin->setRoles(["ROLE_ADMIN"]);

        $manager->persist($admin);

        for ($i = 1; $i < self::USERS_QUANTITY; $i++) {
            $user = new User();

            $user->setEmail(sprintf('user%d@test.com', $i));
            $user->setPassword($this->userPasswordHasher->hashPassword($user, self::PASSWORD));

            $manager->persist($user);
        }

        $manager->flush();
    }

    /** @return array<string> */
    public function getDependencies(): array
    {
        return [];
    }
}

<?php

namespace App\Factory;

use App\DTO\User\UserDTO;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class UserFactory
{
    public function __construct(
      private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function createFromDTO(UserDTO $userDTO): User
    {
        $user = new User();

        $user->setEmail($userDTO->email);
        $hashedPassword = $this->passwordHasher->hashPassword($user, $userDTO->password);
        $user->setPassword($hashedPassword);

        return $user;
    }
}
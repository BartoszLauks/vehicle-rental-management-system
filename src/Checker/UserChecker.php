<?php

namespace App\Checker;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserChecker implements UserCheckerInterface
{

    public function checkPreAuth(UserInterface $user): void
    {
        if (! $user instanceof User) {
            return;
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {

    }

    public static function check(UserInterface $user): User
    {
        if (! $user instanceof User) {
            throw new \Exception('Invalid user exception');
        }

        return $user;
    }
}
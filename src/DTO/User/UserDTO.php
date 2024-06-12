<?php

namespace App\DTO\User;

use App\Validator as Validator;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class UserDTO
{
    public function __construct(?array $userData)
    {
        $this->email = $userData['email'] ?? null;
        $this->password = $userData['password'] ?? null;
    }

    #[Groups(groups: ['api_register'])]
    #[Assert\NotBlank(groups: ['api_register'])]
    #[Assert\Email(groups: ['api_register'])]
    #[Validator\EmailUse(groups: ['api_register'])]
    public ?string $email;

    #[Groups(groups: ['api_register'])]
    #[Assert\NotBlank(groups: ['api_register'])]
    #[Validator\PasswordStrength(groups: ['api_register'])]
    public ?string $password;
}
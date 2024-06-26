<?php

namespace App\DTO\User;

class UserResponseDTO
{
    public int $id;

    public string $email;

    public array $roles = ['ROLE_USER'];
}
<?php

namespace App\DTO\User;

class UserResponseDTO
{
    public int $id;

    public string $email;

    /**
     * @var array|string[]
     */
    public array $roles = ['ROLE_USER'];
}
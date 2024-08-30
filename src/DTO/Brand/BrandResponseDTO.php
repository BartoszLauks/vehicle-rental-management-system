<?php

namespace App\DTO\Brand;

use Symfony\Component\Serializer\Attribute\Groups;

class BrandResponseDTO
{
    #[Groups(['brand:default'])]
    public int $id;
    #[Groups(['brand:default'])]
    public string $name;
}
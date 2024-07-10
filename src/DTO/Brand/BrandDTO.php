<?php

namespace App\DTO\Brand;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as Validator;

final class BrandDTO
{
    /** @param mixed[]|null $brandData */
    public function __construct(?array $brandData)
    {
        $this->name = $brandData['name'] ?? null;
    }

    #[Groups(groups: ['brand:default'])]
    #[Assert\NotBlank(groups: ['brand:default'])]
    #[Validator\BrandNameExists(groups: ['brand:default'])]
    public ?string $name;
}
<?php

namespace App\Factory;

use App\DTO\Brand\BrandDTO;
use App\Entity\Brand;
use App\Repository\BrandRepository;

final readonly class BrandFactory
{
    public function createFromDTO(BrandDTO $brandDTO): Brand
    {
        $brand = new Brand();
        $brand->setName($brandDTO->name);

        return $brand;
    }
}
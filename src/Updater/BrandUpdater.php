<?php

namespace App\Updater;

use App\DTO\Brand\BrandDTO;
use App\Entity\Brand;

class BrandUpdater extends AbstractUpdater
{
    public function put(Brand $brand, BrandDTO $brandDTO): void
    {
        $this->putField($brand, $brandDTO->name, 'setName');
    }
}
<?php

namespace App\DTO\Transformer;

use App\DTO\Brand\BrandResponseDTO;
use App\Factory\ResponseDTOFactory;

final class BrandResponseDTOTransformer extends AbstractResponseDTOTransformer
{
    public function __construct(
        private readonly ResponseDTOFactory $responseDTOFactory
    ) {
    }

    public function transformFromObject(mixed $object): BrandResponseDTO
    {
        return $this->responseDTOFactory->createBrandDTOFromVehicle($object);
    }
}
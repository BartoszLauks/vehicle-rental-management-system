<?php

namespace App\DTO\Transformer;

use App\DTO\Vehicle\VehicleResponseDTO;
use App\Factory\ResponseDTOFactory;

final class VehicleResponseDTOTransformer extends AbstractResponseDTOTransformer
{

    public function __construct(
        private readonly ResponseDTOFactory $responseDTOFactory,
    ) {
    }

    public function transformFromObject(mixed $object): VehicleResponseDTO
    {
        return $this->responseDTOFactory->createVehicleDTOFromVehicle($object);
    }
}
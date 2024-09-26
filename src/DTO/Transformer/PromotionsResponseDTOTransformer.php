<?php

namespace App\DTO\Transformer;

use App\DTO\Promotions\PromotionsResponseDTO;
use App\Factory\ResponseDTOFactory;

final class PromotionsResponseDTOTransformer extends AbstractResponseDTOTransformer
{

    public function __construct(
        private readonly ResponseDTOFactory $responseDTOFactory,
    ) {
    }

    public function transformFromObject(mixed $object): PromotionsResponseDTO
    {
        return $this->responseDTOFactory->createPromotionsDTOFromVehicle($object);
    }
}
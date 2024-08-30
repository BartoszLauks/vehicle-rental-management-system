<?php

declare(strict_types=1);

namespace App\DTO\Transformer;

use App\DTO\Depot\DepotResponseDTO;
use App\Factory\ResponseDTOFactory;

class DepotResponseDTOTransformer extends AbstractResponseDTOTransformer
{

    public function __construct(
        private readonly ResponseDTOFactory $responseDTOFactory,
    )
    {

    }
    public function transformFromObject(mixed $object): DepotResponseDTO
    {
        return $this->responseDTOFactory->createDepotDTOFromDepot($object);
    }
}
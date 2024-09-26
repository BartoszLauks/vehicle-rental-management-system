<?php

declare(strict_types=1);

namespace App\DTO\Promotions;

use App\Enum\DiscountsEnum;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class PromotionsResponseDTO
{
    #[Groups(['promotions:default'])]
    public ?int $id;
    #[Groups(['promotions:default'])]
    public ?string $code;
    #[Groups(['promotions:default'])]
    public ?string $type;
    #[Groups(['promotions:default'])]
    public ?int $value;
    #[Groups(['promotions:default'])]
    public ?string $valid_from;
    #[Groups(['promotions:default'])]
    public ?string $valid_to;
    #[Groups(['promotions:default'])]
    public ?bool $active;
}


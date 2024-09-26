<?php

declare(strict_types=1);

namespace App\DTO\Promotions;

use App\Enum\DiscountsEnum;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class PromotionsDTO
{
    /**
     * @param mixed[]|null $promotionsData
     */
    public function __construct(?array $promotionsData)
    {
        $this->code = $promotionsData['code'] ?? null;
        $this->type = $promotionsData['type'] ?? null;
        $this->value = $promotionsData['value'] ?? null;
        $this->valid_from = $promotionsData['valid_from'] ?? null;
        $this->valid_to = $promotionsData['valid_to'] ?? null;
        $this->active = $promotionsData['active'] ?? null;
    }

    #[Groups(groups: ['promotions:default'])]
    #[Assert\NotBlank(groups: ['promotions:default'])]
    public ?string $code;
    #[Groups(groups: ['promotions:default'])]
    #[Assert\NotBlank(groups: ['promotions:default'])]
    #[Assert\Choice(callback: [DiscountsEnum::class, 'values'], groups: ['promotions:default'])]
    public ?string $type;
    #[Groups(groups: ['promotions:default'])]
    #[Assert\NotBlank(groups: ['promotions:default'])]
    public ?int $value;
    #[Groups(groups: ['promotions:default'])]
    #[Assert\NotBlank(groups: ['promotions:default'])]
    #[Assert\DateTime(groups: ['promotions:default'])]
    public ?string $valid_from;
    #[Assert\NotBlank(groups: ['promotions:default'])]
    #[Groups(groups: ['promotions:default'])]
    #[Assert\DateTime(groups: ['promotions:default'])]
    public ?string $valid_to;
    #[Groups(groups: ['promotions:default'])]
    #[Assert\NotBlank(groups: ['promotions:default'])]
    #[Assert\Type('bool', groups: ['promotions:default'])]
    public ?bool $active;
}

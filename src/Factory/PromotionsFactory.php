<?php

declare(strict_types=1);

namespace App\Factory;

use App\DTO\Promotions\PromotionsDTO;
use App\Entity\Promotions;
use App\Enum\DiscountsEnum;
use App\Validator\MultiFieldValidator;
use DateTimeImmutable;

class PromotionsFactory
{
    public function __construct(
        private readonly MultiFieldValidator $multiFieldValidator
    ) {
    }

    public function createFromDTO(PromotionsDTO $promotionsDTO): Promotions
    {
        $promotions = new Promotions();

        $promotions->setCode($promotionsDTO->code);
        $promotions->setType(DiscountsEnum::from($promotionsDTO->type));
        $promotions->setValue($promotionsDTO->value);
        $promotions->setValidFrom(new DateTimeImmutable($promotionsDTO->valid_from));
        $promotions->setValidTo(new DateTimeImmutable($promotionsDTO->valid_to));


        $promotions->setActive($promotionsDTO->active);

        $this->multiFieldValidator->validate($promotions);

        return $promotions;
    }
}
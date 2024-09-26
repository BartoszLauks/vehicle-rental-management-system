<?php

declare(strict_types=1);

namespace App\Updater;

use App\DTO\Promotions\PromotionsDTO;
use App\Entity\Promotions;
use App\Enum\DiscountsEnum;

class PromotionsUpdater extends AbstractUpdater
{
    public function patch(Promotions $promotions, PromotionsDTO $promotionsDTO): void
    {
        $this->updateField($promotions, $promotionsDTO->code, 'getCode', 'setCode');
        $this->updateField($promotions, DiscountsEnum::from($promotionsDTO->type), 'getType', 'setType');
        $this->updateField($promotions, $promotionsDTO->value, 'getValue', 'setValue');
        $this->updateField($promotions, new \DateTimeImmutable($promotionsDTO->valid_from) , 'getValidFrom', 'setValidFrom');
        $this->updateField($promotions, new \DateTimeImmutable($promotionsDTO->valid_to), 'getValidTo', 'setValidTo');
        $this->updateField($promotions, $promotionsDTO->active, 'getActive', 'setActive');
    }
}
<?php

declare(strict_types=1);

namespace App\Enum;

enum DiscountsEnum: string
{
    case PERCENTAGE = 'PERCENTAGE';
    case FIXED = 'FIXED';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

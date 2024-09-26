<?php

declare(strict_types=1);

namespace App\Enum;

enum BookingStatus: string
{
    case ORDERED = 'ORDERED';
    case PAYMENT = 'PAYMENT';
    case PREPARATION = 'PREPARATION';
    case PAID = 'PAID';
    case SHIPPING = 'SHIPPING';
    case DELIVERED = 'DELIVERED';
    case RETURNED = 'RETURNED';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

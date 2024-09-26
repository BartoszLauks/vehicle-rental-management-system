<?php

declare(strict_types=1);

namespace App\Enum;

enum StripePaymentStatus: string
{
    case SUCCEEDED = 'SUCCEEDED';
    case PENDING = 'PENDING';
    case FAILED = 'FAILED';
    case CANCELED = 'CANCELED';
    case REQUIRES_ACTION = 'REQUIRES_ACTION';
    case REQUIRES_PAYMENT_METHOD = 'REQUIRES_PAYMENT_METHOD';
    case REQUIRES_CONFIRMATION = 'REQUIRES_CONFIRMATION';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getDescription(): string
    {
        return match ($this) {
            StripePaymentStatus::SUCCEEDED => 'The payment was successful, and the funds have been captured.',
            StripePaymentStatus::PENDING => "The payment is pending and hasn't been fully processed yet.",
            StripePaymentStatus::FAILED => 'The payment failed due to an issue, such as insufficient funds or incorrect card details.',
            StripePaymentStatus::CANCELED  => 'The payment was canceled, either by the user or due to a timeout or other issue.',
            StripePaymentStatus::REQUIRES_ACTION => 'The payment requires further action from the customer, such as authentication.',
            StripePaymentStatus::REQUIRES_PAYMENT_METHOD => 'The payment attempt failed, and a new payment method is needed.',
            StripePaymentStatus::REQUIRES_CONFIRMATION => 'The payment needs to be confirmed, typically for manual confirmation flows.',
        };
    }
}

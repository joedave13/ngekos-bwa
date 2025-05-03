<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum TransactionPaymentMethod: string implements HasLabel
{
    case DOWN_PAYMENT = 'down_payment';
    case FULL_PAYMENT = 'full_payment';

    public function getLabel(): ?string
    {
        return str(str($this->value)->replace('_', ' '))->title();
    }
}

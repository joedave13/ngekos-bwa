<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum TransactionPaymentStatus: string implements HasLabel
{
    case PENDING = 'pending';
    case SUCCESS = 'success';
    case FAILED = 'failed';

    public function getLabel(): ?string
    {
        return str(str($this->value)->replace('_', ' '))->title();
    }
}

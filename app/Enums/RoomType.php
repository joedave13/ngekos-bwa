<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum RoomType: string implements HasLabel
{
    case STANDART = 'standart';
    case DELUXE = 'deluxe';
    case PRESIDENT = 'president';

    public function getLabel(): ?string
    {
        return str(str($this->value)->replace('_', ' '))->title();
    }

    public function getColor(): string
    {
        return match ($this) {
            self::STANDART => 'primary',
            self::DELUXE => 'info',
            self::PRESIDENT => 'warning'
        };
    }
}

<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;


enum Season: string implements HasLabel

{
    case High = 'high';
    case Low = 'low';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::High => 'Alta',
            self::Low => 'Baja',
        };
    }
}

<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;


enum Scope: string implements HasLabel

{
    case NATIONAL = 'Nacional';
    case INTERNATIONAL = 'Internacional';


    public function getLabel(): ?string
    {
        return match ($this) {
            self::NATIONAL => 'Nacional',
            self::INTERNATIONAL => 'Internacional',
        };
    }
}

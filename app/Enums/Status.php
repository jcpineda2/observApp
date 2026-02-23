<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;


enum Status: string implements HasLabel

{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';


    public function getLabel(): ?string
    {
        return match ($this) {
            self::ACTIVE => 'Activo',
            self::INACTIVE => 'Inactivo',
        };
    }
}

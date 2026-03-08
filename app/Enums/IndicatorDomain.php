<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum IndicatorDomain: string implements HasLabel


{
    case Domestic = 'domestic';
    case Inbound = 'inbound';
    case Providers = 'providers';
    case Accommodation = 'accommodation';
    case Employment = 'employment';
    case Connectivity = 'connectivity';

    public function getLabel(): ?string
    {
        return match ($this){
            self::Domestic => 'Turismo interno',
            self::Inbound => 'Turismo receptivo',
            self::Providers => 'Prestadores',
            self::Accommodation => 'Alojamientos',
            self::Employment => 'Empleo',
            self::Connectivity => 'Conectividad',
        };
    }
}

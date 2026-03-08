<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;


enum IndicatorKey: string implements HasLabel
{
    case AvgSpendFixed = 'avg_spend_fixed';
    case AvgStayFixed = 'avg_stay_fixed';


    public function getLabel(): ?string
    {
        return match ($this) {
            self::AvgSpendFixed => 'Gasto promedio fijo',
            self::AvgStayFixed => 'Estadía promedio fija',
        };
    }
}

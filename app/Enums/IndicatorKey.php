<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum IndicatorKey: string implements HasLabel
{
    case AvgSpendFixed = 'avg_spend_fixed';
    case AvgStayFixed = 'avg_stay_fixed';

    case ExpenseCompositionFood = 'expense_composition_food';
    case ExpenseCompositionLodging = 'expense_composition_lodging';
    case ExpenseCompositionTransport = 'expense_composition_transport';
    case ExpenseCompositionShopping = 'expense_composition_shopping';
    case ExpenseCompositionOther = 'expense_composition_other';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::AvgSpendFixed => 'Gasto promedio fijo',
            self::AvgStayFixed => 'Estadía promedio fija',
            self::ExpenseCompositionFood => 'Composición del gasto: Alimentación',
            self::ExpenseCompositionLodging => 'Composición del gasto: Alojamiento',
            self::ExpenseCompositionTransport => 'Composición del gasto: Transporte',
            self::ExpenseCompositionShopping => 'Composición del gasto: Compras',
            self::ExpenseCompositionOther => 'Composición del gasto: Otros',
        };
    }
}

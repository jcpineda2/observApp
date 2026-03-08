<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
    <livewire:public-interface.kpi-card
        :key="'inbound-tourists-'.$year.'-'.$month"
        title="Llegadas de turistas"
        :value="number_format($tourists, 0, ',', '.')"
        badge="Observado"
        helpText="Total según filtros aplicados"
    />

    <livewire:public-interface.kpi-card
        :key="'inbound-excursionists-'.$year.'-'.$month"
        title="Llegadas de excursionistas"
        :value="number_format($excursionists, 0, ',', '.')"
        badge="Observado"
        helpText="Visitantes sin pernocte"
    />

    <livewire:public-interface.kpi-card
        :key="'inbound-foreign-exchange-'.$year.'-'.$month"
        title="Ingresos de divisas"
        :value="number_format($foreignExchangeRevenue, 2, ',', '.')"
        unit="USD"
        badge="Observado"
        helpText="Suma según registros cargados"
    />

    <livewire:public-interface.kpi-card
        :key="'inbound-fixed-average-spend-'.$year"
        title="Gasto promedio"
        :value="$fixedAverageSpend !== null ? number_format($fixedAverageSpend, 2, ',', '.') : '-'"
        :unit="$fixedAverageSpendUnit"
        badge="Dato fijo"
        :source="$fixedAverageSpendSource"
        helpText="Valor oficial de referencia"
    />

    <livewire:public-interface.kpi-card
        :key="'inbound-fixed-average-stay-'.$year"
        title="Estadía promedio"
        :value="$fixedAverageStay !== null ? number_format($fixedAverageStay, 2, ',', '.') : '-'"
        :unit="$fixedAverageStayUnit"
        badge="Dato fijo"
        :source="$fixedAverageStaySource"
        helpText="Valor oficial de referencia"
    />
</div>

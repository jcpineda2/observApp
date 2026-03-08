<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
    <livewire:public-interface.kpi-card
        :key="'domestic-tourists-'.$year.'-'.$month"
        title="Turistas internos"
        :value="number_format($tourists, 0, ',', '.')"
        badge="Observado"
        helpText="Total según filtros aplicados"
    />

    <livewire:public-interface.kpi-card
        :key="'domestic-total-spend-'.$year.'-'.$month"
        title="Gasto total observado"
        :value="number_format($totalSpendObserved, 2, ',', '.')"
        unit="Gs."
        badge="Observado"
        helpText="Suma del gasto turístico según registros cargados"
    />

    <livewire:public-interface.kpi-card
        :key="'domestic-avg-stay-'.$year.'-'.$month"
        title="Estadía promedio observada"
        :value="number_format($avgStayObserved, 2, ',', '.')"
        unit="noches"
        badge="Observado"
        helpText="Promedio calculado desde registros cargados"
    />
</div>

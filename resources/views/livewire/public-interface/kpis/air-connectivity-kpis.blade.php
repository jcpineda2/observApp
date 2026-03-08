<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
    <livewire:public-interface.kpi-card
        :key="'air-op-nat'.$year.'-'.$month"
        title="Aerop. operativos (Nac.)"
        :value="number_format($operationalNationalAirports, 0, ',', '.')"
    />

    <livewire:public-interface.kpi-card
        :key="'air-op-int-'.$year.'-'.$month"
        title="Aerop. operativos (Int.)"
        :value="number_format($operationalInternationalAirports, 0, ',', '.')"
    />

    <livewire:public-interface.kpi-card
        :key="'air-dest-'.$year.'-'.$month"
        title="Destinos conectados"
        :value="number_format($connectedDestinations, 0, ',', '.')"
    />

   <livewire:public-interface.kpi-card
        :key="'air-active-'.$year.'-'.$month"
        title="Rutas activas"
        :value="number_format($activeRoutes, 0, ',', '.')"
    />

    <livewire:public-interface.kpi-card
        :key="'air-flights-'.$year.'-'.$month"
        title="Vuelos"
        :value="number_format($totalFlights, 0, ',', '.')"
    />

    <livewire:public-interface.kpi-card
        :key="'air-seats-'.$year.'-'.$month"
        title="Asientos"
        :value="number_format($totalSeats, 0, ',', '.')"
    />

    <livewire:public-interface.kpi-card
        :key="'air-airlines-'.$year.'-'.$month"
        title="Aerolíneas"
        :value="number_format($airlines, 0, ',', '.')"
    />

    <livewire:public-interface.kpi-card
        :key="'air-airports-'.$year.'-'.$month"
        title="Aerop. en rutas"
        :value="number_format($airportsInRoutes, 0, ',', '.')"
    />
</div>

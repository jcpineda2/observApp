<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <livewire:public-interface.kpi-card
        :key="'cap-rooms-'.$year.'-'.$month"
        title="Habitaciones instaladas (período)"
        :value="$installedRooms !== null ? number_format($installedRooms, 0, ',', '.') : '—'"
    />

    <livewire:public-interface.kpi-card
        :key="'cap-beds-'.$year.'-'.$month"
        title="Camas instaladas (período)"
        :value="$installedBeds !== null ? number_format($installedBeds, 0, ',', '.') : '—'"
    />

    <livewire:public-interface.kpi-card
        :key="'cap-seats-'.$year.'-'.$month"
        title="Plazas instaladas (período)"
        :value="$installedSeats !== null ? number_format($installedSeats, 0, ',', '.') : '—'"
    />

    <livewire:public-interface.kpi-card
        :key="'cap-total-'.$year.'-'.$month"
        title="Capacidad (camas+plazas)"
        :value="number_format((int)($installedBeds ?? 0) + (int)($installedSeats ?? 0), 0, ',', '.')"
    />
</div>

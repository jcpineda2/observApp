<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <livewire:public-interface.kpi-card
        :key="'emp-direct-'.$year"
        title="Empleo directo (total)"
        :value="number_format($directEmploymentTotal, 0, ',', '.')"
    />

    <livewire:public-interface.kpi-card
        :key="'emp-part-'.$year"
        title="Participación en empleo nacional (prom.)"
        :value="number_format($avgNationalParticipation, 2, ',', '.') . '%'"
    />

    <livewire:public-interface.kpi-card
        :key="'emp-var-'.$year"
        title="Variación interanual (prom.)"
        :value="number_format($avgInterannualVariation, 2, ',', '.') . '%'"
    />

    <livewire:public-interface.kpi-card
        :key="'emp-seg-'.$year"
        title="Segmentos (rubro)"
        :value="number_format($segmentsCount, 0, ',', '.')"
    />
</div>

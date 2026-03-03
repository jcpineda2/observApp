<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

    @foreach($items as $item)
        <livewire:public-interface.kpi-card
            :title="$item['title']"
            :value="$item['value']"
            :subtitle="$item['subtitle'] ?? null"
            :trend="$item['trend'] ?? null"
            :trendDirection="$item['trendDirection'] ?? null"
            :key="$loop->index"
        />
    @endforeach

</div>

<div class="kpi-grid">
    @foreach ($items as $item)
        <livewire:public-interface.kpi-card
            :title="$item['title']"
            :value="$item['value']"
            :subtitle="$item['subtitle'] ?? null"
            :trend="$item['trend'] ?? null"
            :trendDirection="$item['trendDirection'] ?? null"
            :key="'kpi-' . md5($item['title'])"
        />
    @endforeach
</div>

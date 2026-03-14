@props([
    'title',
    'subtitle' => null,
    'items' => [],
    'valueSuffix' => null,
])

<div class="ranking-card">
    <div class="ranking-card-header">
        <h3 class="ranking-card-title">
            {{ $title }}
        </h3>

        @if ($subtitle)
            <p class="ranking-card-subtitle">
                {{ $subtitle }}
            </p>
        @endif
    </div>

    <div class="ranking-card-body">
        @if (empty($items))
            <div class="public-empty-state">
                No hay datos disponibles para este ranking.
            </div>
        @else
            <div class="ranking-list">
                @foreach ($items as $index => $item)
                    <div class="ranking-row">
                        <div class="flex items-center gap-3">
                            <div class="ranking-index">
                                {{ $index + 1 }}
                            </div>

                            <div class="ranking-label">
                                {{ $item['label'] ?? 'Sin etiqueta' }}
                            </div>
                        </div>

                        <div class="ranking-value">
                            {{ $item['value'] ?? 0 }}{{ $valueSuffix ? ' '.$valueSuffix : '' }}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

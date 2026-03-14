@props([
    'mapId',
    'geoJsonUrl',
    'values' => [],
    'title' => 'Mapa',
    'subtitle' => null,
    'height' => 650,
])

<div class="map-card">
    <div class="map-card-header">
        <div>
            <h3 class="map-card-title">
                {{ $title }}
            </h3>

            @if ($subtitle)
                <p class="map-card-subtitle">
                    {{ $subtitle }}
                </p>
            @endif
        </div>
    </div>

    <div class="map-card-body">
        <div
            wire:ignore
            class="relative w-full overflow-hidden rounded-xl border border-gray-200 bg-white"
            style="height: {{ $height }}px;"
            x-data="paraguayDepartmentMap({
                mapId: @js($mapId),
                geoJsonUrl: @js($geoJsonUrl),
                values: @js($values),
            })"
            x-init="init()"
        >
            <div
                x-show="isLoading"
                x-transition.opacity
                class="paraguay-map-loading"
            >
                Cargando mapa…
            </div>

            <div
                x-show="!isLoading && isEmpty"
                x-transition.opacity
                class="paraguay-map-empty-state"
            >
                No hay datos disponibles para mostrar en el mapa.
            </div>

            <div id="{{ $mapId }}" class="h-full w-full rounded-xl"></div>

            <div
                x-show="!isLoading"
                class="paraguay-map-legend"
            >
                <div class="paraguay-map-legend-title">Intensidad</div>

                <div class="paraguay-map-legend-scale">
                    <span style="background:#ececf8"></span>
                    <span style="background:#dcdffd"></span>
                    <span style="background:#b8c0ff"></span>
                    <span style="background:#8798ff"></span>
                    <span style="background:#5e74ff"></span>
                    <span style="background:#2f49ff"></span>
                </div>

                <div class="paraguay-map-legend-labels">
                    <span>Menor</span>
                    <span>Mayor</span>
                </div>
            </div>
        </div>
    </div>
</div>

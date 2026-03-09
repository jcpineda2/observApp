@props([
    'mapId',
    'geoJsonUrl',
    'values' => [],
    'title' => 'Mapa',
    'subtitle' => null,
    'height' => 650,
])

<div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
    <div class="flex items-start justify-between gap-3">
        <div>
            <h3 class="text-sm font-semibold text-gray-900">
                {{ $title }}
            </h3>

            @if ($subtitle)
                <p class="mt-1 text-xs text-gray-500">
                    {{ $subtitle }}
                </p>
            @endif
        </div>
    </div>

    <div class="mt-4">
        <div
            class="w-full rounded-xl border border-gray-200"
            style="height: {{ $height }}px;"
            x-data="paraguayDepartmentMap({
                mapId: '{{ $mapId }}',
                geoJsonUrl: '{{ $geoJsonUrl }}',
                values: @js($values),
            })"
            x-init="init()"
            wire:ignore
        >
            <div id="{{ $mapId }}" class="h-full w-full rounded-xl"></div>
        </div>
    </div>
</div>

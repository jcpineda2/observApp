<div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200">

    <div class="flex items-start justify-between">
        <div>
            <h3 class="text-sm font-semibold text-gray-900">
                Variación interanual de ocupación
            </h3>
            <p class="mt-1 text-xs text-gray-500">
                Comparación mensual año actual vs anterior
            </p>
        </div>

        <div class="text-right">
            <span class="text-xs text-gray-500 block">YoY promedio</span>
            <span class="text-lg font-bold {{ $yoyAverage >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                {{ $yoyAverage }}%
            </span>
        </div>
    </div>

    <div class="mt-4">
        <div
            class="relative w-full"
            style="height: 340px;"
            x-data="observatorioChart(@js($this->chartConfig()), '{{ $chartId }}')"
            x-init="init($refs.canvas)"
            wire:ignore
        >
            <canvas x-ref="canvas" id="{{ $chartId }}"></canvas>
        </div>
    </div>
</div>

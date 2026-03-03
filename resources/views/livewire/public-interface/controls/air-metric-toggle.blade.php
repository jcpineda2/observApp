<div class="flex items-center justify-end">
    <div class="inline-flex rounded-xl bg-gray-100 p-1 ring-1 ring-gray-200"
         x-data="{ metric: @entangle('metric') }">
        <button type="button"
            class="px-3 py-1.5 text-xs font-semibold rounded-lg"
            :class="metric === 'seats' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-600'"
            @click="metric='seats'; $wire.setMetric('seats')">
            Asientos
        </button>

        <button type="button"
            class="px-3 py-1.5 text-xs font-semibold rounded-lg"
            :class="metric === 'flights' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-600'"
            @click="metric='flights'; $wire.setMetric('flights')">
            Vuelos
        </button>
    </div>
</div>

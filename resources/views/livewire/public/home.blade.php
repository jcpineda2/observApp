<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
    <button
        type="button"
        wire:click="$dispatch('go-to-tab', { tab: 'prestadores' })"
        class="ui-surface p-5 text-left transition hover:shadow-md"
    >
        <div class="text-sm font-semibold text-gray-900 dark:text-white">Prestadores</div>
        <p class="mt-2 text-xs text-gray-500 dark:text-slate-300">
            Total, altas, bajas y formalización de prestadores turísticos.
        </p>
    </button>

    <button
        type="button"
        wire:click="$dispatch('go-to-tab', { tab: 'turismo-receptivo' })"
        class="ui-surface p-5 text-left transition hover:shadow-md"
    >
        <div class="text-sm font-semibold text-gray-900 dark:text-white">Turismo receptivo</div>
        <p class="mt-2 text-xs text-gray-500 dark:text-slate-300">
            Indicadores de entrada, mercado emisor y comportamiento del visitante.
        </p>
    </button>

    <button
        type="button"
        wire:click="$dispatch('go-to-tab', { tab: 'turismo-interno' })"
        class="ui-surface p-5 text-left transition hover:shadow-md"
    >
        <div class="text-sm font-semibold text-gray-900 dark:text-white">Turismo interno</div>
        <p class="mt-2 text-xs text-gray-500 dark:text-slate-300">
            Flujo, gasto, estadía promedio y comportamiento del turismo interno.
        </p>
    </button>
</div>

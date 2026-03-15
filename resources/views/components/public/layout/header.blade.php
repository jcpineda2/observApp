<header class="sticky top-0 z-40 border-b border-gray-200 bg-white/95 backdrop-blur dark:border-slate-800 dark:bg-slate-950/95">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
        <a wire:navigate href="{{ route('public.home') }}" class="flex items-center gap-3 shrink-0">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[var(--color-senatur-blue)] text-sm font-bold text-white">
                OT
            </div>

            <div class="min-w-0">
                <p class="truncate text-sm font-semibold text-gray-900 dark:text-white">
                    Observatorio Turístico
                </p>
                <p class="truncate text-xs text-gray-500 dark:text-slate-400">
                    SENATUR
                </p>
            </div>
        </a>

        <nav class="hidden items-center gap-2 lg:flex">
            <a wire:navigate href="{{ route('public.home') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:text-slate-200 dark:hover:bg-slate-800">Inicio</a>
            <a wire:navigate href="{{ route('public.inbound') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:text-slate-200 dark:hover:bg-slate-800">Receptivo</a>
            <a wire:navigate href="{{ route('public.domestic') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:text-slate-200 dark:hover:bg-slate-800">Interno</a>
            <a wire:navigate href="{{ route('public.providers') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:text-slate-200 dark:hover:bg-slate-800">Prestadores</a>
            <a wire:navigate href="{{ route('public.accommodation') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:text-slate-200 dark:hover:bg-slate-800">Alojamientos</a>
            <a wire:navigate href="{{ route('public.employment') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:text-slate-200 dark:hover:bg-slate-800">Empleo</a>
            <a wire:navigate href="{{ route('public.connectivity') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:text-slate-200 dark:hover:bg-slate-800">Conectividad</a>
        </nav>
    </div>
</header>

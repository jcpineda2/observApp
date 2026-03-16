@php
    $currentRoute = request()->route()?->getName();
@endphp

<header x-data="{ mobileOpen: false }"
    class="sticky top-0 z-50 border-b border-gray-200 bg-white/95 backdrop-blur dark:border-slate-800 dark:bg-slate-950/95">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
        <a wire:navigate href="{{ route('public.home') }}" class="flex min-w-0 items-center gap-3 shrink-0">
            <div
                class="flex h-10 w-10 items-center justify-center rounded-xl bg-[var(--color-senatur-blue)] text-sm font-bold text-white">
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

        {{-- Desktop nav --}}
        <nav class="hidden items-center gap-1 lg:flex">
            <a wire:navigate href="{{ route('public.home') }}" @class([
                'rounded-lg px-3 py-2 text-sm font-medium transition',
                'bg-gray-100 text-gray-900 dark:bg-slate-800 dark:text-white' =>
                    $currentRoute === 'public.home',
                'text-gray-700 hover:bg-gray-100 dark:text-slate-200 dark:hover:bg-slate-800' =>
                    $currentRoute !== 'public.home',
            ])>
                Inicio
            </a>

            <a wire:navigate href="{{ route('public.inbound') }}" @class([
                'rounded-lg px-3 py-2 text-sm font-medium transition',
                'bg-gray-100 text-gray-900 dark:bg-slate-800 dark:text-white' =>
                    $currentRoute === 'public.inbound',
                'text-gray-700 hover:bg-gray-100 dark:text-slate-200 dark:hover:bg-slate-800' =>
                    $currentRoute !== 'public.inbound',
            ])>
                Receptivo
            </a>

            <a wire:navigate href="{{ route('public.domestic') }}" @class([
                'rounded-lg px-3 py-2 text-sm font-medium transition',
                'bg-gray-100 text-gray-900 dark:bg-slate-800 dark:text-white' =>
                    $currentRoute === 'public.domestic',
                'text-gray-700 hover:bg-gray-100 dark:text-slate-200 dark:hover:bg-slate-800' =>
                    $currentRoute !== 'public.domestic',
            ])>
                Interno
            </a>

            <a wire:navigate href="{{ route('public.providers') }}" @class([
                'rounded-lg px-3 py-2 text-sm font-medium transition',
                'bg-gray-100 text-gray-900 dark:bg-slate-800 dark:text-white' =>
                    $currentRoute === 'public.providers',
                'text-gray-700 hover:bg-gray-100 dark:text-slate-200 dark:hover:bg-slate-800' =>
                    $currentRoute !== 'public.providers',
            ])>
                Prestadores
            </a>

            <a wire:navigate href="{{ route('public.accommodation') }}" @class([
                'rounded-lg px-3 py-2 text-sm font-medium transition',
                'bg-gray-100 text-gray-900 dark:bg-slate-800 dark:text-white' =>
                    $currentRoute === 'public.accommodation',
                'text-gray-700 hover:bg-gray-100 dark:text-slate-200 dark:hover:bg-slate-800' =>
                    $currentRoute !== 'public.accommodation',
            ])>
                Alojamientos
            </a>

            <a wire:navigate href="{{ route('public.employment') }}" @class([
                'rounded-lg px-3 py-2 text-sm font-medium transition',
                'bg-gray-100 text-gray-900 dark:bg-slate-800 dark:text-white' =>
                    $currentRoute === 'public.employment',
                'text-gray-700 hover:bg-gray-100 dark:text-slate-200 dark:hover:bg-slate-800' =>
                    $currentRoute !== 'public.employment',
            ])>
                Empleo
            </a>

            <a wire:navigate href="{{ route('public.connectivity') }}" @class([
                'rounded-lg px-3 py-2 text-sm font-medium transition',
                'bg-gray-100 text-gray-900 dark:bg-slate-800 dark:text-white' =>
                    $currentRoute === 'public.connectivity',
                'text-gray-700 hover:bg-gray-100 dark:text-slate-200 dark:hover:bg-slate-800' =>
                    $currentRoute !== 'public.connectivity',
            ])>
                Conectividad
            </a>
        </nav>

        <div class="flex items-center gap-2">
            <button type="button"
                class="hidden h-10 items-center justify-center gap-2 rounded-xl border border-gray-200 px-3 text-sm font-medium text-gray-600 transition hover:bg-gray-100 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800 lg:inline-flex"
                aria-label="Cambiar tema" data-theme-toggle>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 theme-icon-light" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 3v2.25M12 18.75V21M4.72 4.72l1.59 1.59M17.69 17.69l1.59 1.59M3 12h2.25M18.75 12H21M4.72 19.28l1.59-1.59M17.69 6.31l1.59-1.59M15.75 12A3.75 3.75 0 1112 8.25 3.75 3.75 0 0115.75 12z" />
                </svg>

                <svg xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5 theme-icon-dark" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 12.79A9 9 0 1111.21 3c0 .34.02.67.05 1A7 7 0 0020 11.74c.33.03.66.05 1 .05z" />
                </svg>

                <span data-theme-label>Tema claro</span>
            </button>

            {{-- Mobile menu  --}}
            <button type="button" x-on:click="mobileOpen = !mobileOpen"
                class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200 text-gray-700 transition hover:bg-gray-100 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800 lg:hidden"
                :aria-expanded="mobileOpen ? 'true' : 'false'" aria-controls="public-mobile-menu"
                aria-label="Abrir menú de navegación">
                <svg x-show="!mobileOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>

                <svg x-show="mobileOpen" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile nav --}}
    <div id="public-mobile-menu" x-show="mobileOpen" x-collapse x-cloak
        class="border-t border-gray-200 bg-white dark:border-slate-800 dark:bg-slate-950 lg:hidden">
        <nav class="mx-auto flex max-w-7xl flex-col gap-1 px-4 py-4 sm:px-6">
            <a wire:navigate href="{{ route('public.home') }}" x-on:click="mobileOpen = false"
                @class([
                    'rounded-xl px-4 py-3 text-sm font-medium transition',
                    'bg-gray-100 text-gray-900 dark:bg-slate-800 dark:text-white' =>
                        $currentRoute === 'public.home',
                    'text-gray-700 hover:bg-gray-100 dark:text-slate-200 dark:hover:bg-slate-800' =>
                        $currentRoute !== 'public.home',
                ])>
                Inicio
            </a>

            <a wire:navigate href="{{ route('public.inbound') }}" x-on:click="mobileOpen = false"
                @class([
                    'rounded-xl px-4 py-3 text-sm font-medium transition',
                    'bg-gray-100 text-gray-900 dark:bg-slate-800 dark:text-white' =>
                        $currentRoute === 'public.inbound',
                    'text-gray-700 hover:bg-gray-100 dark:text-slate-200 dark:hover:bg-slate-800' =>
                        $currentRoute !== 'public.inbound',
                ])>
                Turismo receptivo
            </a>

            <a wire:navigate href="{{ route('public.domestic') }}" x-on:click="mobileOpen = false"
                @class([
                    'rounded-xl px-4 py-3 text-sm font-medium transition',
                    'bg-gray-100 text-gray-900 dark:bg-slate-800 dark:text-white' =>
                        $currentRoute === 'public.domestic',
                    'text-gray-700 hover:bg-gray-100 dark:text-slate-200 dark:hover:bg-slate-800' =>
                        $currentRoute !== 'public.domestic',
                ])>
                Turismo interno
            </a>

            <a wire:navigate href="{{ route('public.providers') }}" x-on:click="mobileOpen = false"
                @class([
                    'rounded-xl px-4 py-3 text-sm font-medium transition',
                    'bg-gray-100 text-gray-900 dark:bg-slate-800 dark:text-white' =>
                        $currentRoute === 'public.providers',
                    'text-gray-700 hover:bg-gray-100 dark:text-slate-200 dark:hover:bg-slate-800' =>
                        $currentRoute !== 'public.providers',
                ])>
                Prestadores
            </a>

            <a wire:navigate href="{{ route('public.accommodation') }}" x-on:click="mobileOpen = false"
                @class([
                    'rounded-xl px-4 py-3 text-sm font-medium transition',
                    'bg-gray-100 text-gray-900 dark:bg-slate-800 dark:text-white' =>
                        $currentRoute === 'public.accommodation',
                    'text-gray-700 hover:bg-gray-100 dark:text-slate-200 dark:hover:bg-slate-800' =>
                        $currentRoute !== 'public.accommodation',
                ])>
                Alojamientos
            </a>

            <a wire:navigate href="{{ route('public.employment') }}" x-on:click="mobileOpen = false"
                @class([
                    'rounded-xl px-4 py-3 text-sm font-medium transition',
                    'bg-gray-100 text-gray-900 dark:bg-slate-800 dark:text-white' =>
                        $currentRoute === 'public.employment',
                    'text-gray-700 hover:bg-gray-100 dark:text-slate-200 dark:hover:bg-slate-800' =>
                        $currentRoute !== 'public.employment',
                ])>
                Empleo
            </a>

            <a wire:navigate href="{{ route('public.connectivity') }}" x-on:click="mobileOpen = false"
                @class([
                    'rounded-xl px-4 py-3 text-sm font-medium transition',
                    'bg-gray-100 text-gray-900 dark:bg-slate-800 dark:text-white' =>
                        $currentRoute === 'public.connectivity',
                    'text-gray-700 hover:bg-gray-100 dark:text-slate-200 dark:hover:bg-slate-800' =>
                        $currentRoute !== 'public.connectivity',
                ])>
                Conectividad
            </a>

            <div class="mt-3 border-t border-gray-200 pt-3 dark:border-slate-800">
                <button type="button"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-gray-200 px-4 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800"
                    aria-label="Cambiar tema" data-theme-toggle>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 theme-icon-light" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3v2.25M12 18.75V21M4.72 4.72l1.59 1.59M17.69 17.69l1.59 1.59M3 12h2.25M18.75 12H21M4.72 19.28l1.59-1.59M17.69 6.31l1.59-1.59M15.75 12A3.75 3.75 0 1112 8.25 3.75 3.75 0 0115.75 12z" />
                    </svg>

                    <svg xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5 theme-icon-dark" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 12.79A9 9 0 1111.21 3c0 .34.02.67.05 1A7 7 0 0020 11.74c.33.03.66.05 1 .05z" />
                    </svg>

                    <span data-theme-label>Tema claro</span>
                </button>
            </div>
        </nav>
    </div>
</header>

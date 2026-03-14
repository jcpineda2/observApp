<header
    x-data="{ open: false }"
    class="sticky top-0 z-50 border-b border-gray-200 bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/80 dark:border-[var(--color-app-dark-border)] dark:bg-[var(--color-app-dark-surface)]/95 dark:supports-[backdrop-filter]:bg-[var(--color-app-dark-surface)]/80"
>
    <div class="ui-shell">
        <div class="flex h-20 items-center justify-between gap-4">

            {{-- Logo / Branding --}}
            <a href="" class="flex shrink-0 items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[var(--color-senatur-blue)] text-white shadow-sm">
                    <span class="text-sm font-bold tracking-wide">S</span>
                </div>

                <div class="leading-tight">
                    <div class="text-sm font-semibold uppercase tracking-wide text-gray-900 dark:text-white">
                        SENATUR
                    </div>
                    <div class="text-xs text-gray-500 dark:text-slate-300">
                        Observatorio Turístico
                    </div>
                </div>
            </a>

            {{-- Navegación desktop --}}
            <nav class="hidden items-center gap-1 xl:flex">
                @php
                    $links = [
                        'public.domestic' => 'Turismo interno',
                        'public.inbound' => 'Turismo receptivo',
                        'public.providers' => 'Prestadores',
                        'public.accommodation' => 'Alojamientos',
                        'public.employment' => 'Empleo',
                        'public.connectivity' => 'Conectividad',
                    ];
                @endphp

                @foreach ($links as $routeName => $label)
                    <a
                        href="{{ route($routeName) }}"
                        @class([
                            'rounded-full px-4 py-2 text-sm font-medium transition',
                            'bg-[var(--color-senatur-blue)] text-white' => request()->routeIs($routeName),
                            'text-gray-700 hover:bg-gray-100 dark:text-slate-200 dark:hover:bg-slate-700/70' => !request()->routeIs($routeName),
                        ])
                    >
                        {{ $label }}
                    </a>
                @endforeach
            </nav>

            {{-- Acciones derecha --}}
            <div class="flex shrink-0 items-center gap-2">

                {{-- Toggle modo oscuro desktop --}}
                <button
                    type="button"
                    @click="darkMode = !darkMode"
                    class="hidden md:inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-[var(--color-app-dark-border)] dark:bg-slate-800 dark:text-slate-100 dark:hover:bg-slate-700"
                >
                    <span x-show="!darkMode">Modo oscuro</span>
                    <span x-show="darkMode">Modo claro</span>
                </button>

                {{-- Botón menú mobile --}}
                <button
                    type="button"
                    class="inline-flex items-center justify-center rounded-lg p-2 text-gray-700 hover:bg-gray-100 xl:hidden dark:text-white dark:hover:bg-slate-700"
                    @click="open = !open"
                >
                    <svg
                        x-show="!open"
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>

                    <svg
                        x-show="open"
                        x-cloak
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

            </div>
        </div>
    </div>

    {{-- Menú mobile --}}
    <div
        x-show="open"
        x-cloak
        class="border-t border-gray-200 bg-white xl:hidden dark:border-[var(--color-app-dark-border)] dark:bg-[var(--color-app-dark-surface)]"
    >
        <div class="ui-shell py-4">

            <nav class="flex flex-col gap-2">
                @foreach ($links as $routeName => $label)
                    <a
                        href="{{ route($routeName) }}"
                        class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-slate-100 dark:hover:bg-slate-700"
                    >
                        {{ $label }}
                    </a>
                @endforeach
            </nav>

            {{-- Toggle dark mode mobile --}}
            <div class="mt-4 md:hidden">
                <button
                    type="button"
                    @click="darkMode = !darkMode"
                    class="w-full ui-btn-secondary"
                >
                    <span x-show="!darkMode">Modo oscuro</span>
                    <span x-show="darkMode">Modo claro</span>
                </button>
            </div>

        </div>
    </div>
</header>

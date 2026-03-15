<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Aplicar tema antes de pintar la página para evitar parpadeo --}}
    <script>
        (function () {
            const savedTheme = localStorage.getItem('darkMode');

            if (savedTheme === 'true') {
                document.documentElement.classList.add('dark');
            } else if (savedTheme === 'false') {
                document.documentElement.classList.remove('dark');
            } else {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                document.documentElement.classList.toggle('dark', prefersDark);
            }
        })();
    </script>

    {{-- Store global de Alpine para el tema --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                dark: localStorage.getItem('darkMode') === 'true'
                    ? true
                    : localStorage.getItem('darkMode') === 'false'
                        ? false
                        : window.matchMedia('(prefers-color-scheme: dark)').matches,

                toggle() {
                    this.dark = !this.dark;
                    this.apply();
                },

                apply() {
                    document.documentElement.classList.toggle('dark', this.dark);
                    localStorage.setItem('darkMode', this.dark ? 'true' : 'false');
                },
            });

            Alpine.store('theme').apply();
        });

        document.addEventListener('livewire:navigated', () => {
            if (window.Alpine && Alpine.store('theme')) {
                Alpine.store('theme').apply();
            }

            const page = document.getElementById('page-content');
            const loader = document.getElementById('page-loader');

            requestAnimationFrame(() => {
                page?.classList.remove('is-loading');
                loader?.classList.remove('is-loading');
            });
        });

        document.addEventListener('livewire:navigate', () => {
            const page = document.getElementById('page-content');
            const loader = document.getElementById('page-loader');

            page?.classList.add('is-loading');
            loader?.classList.add('is-loading');
        });
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="ui-page">
    {{-- Loader superior de navegación --}}
    <div id="page-loader" class="page-loader"></div>

    {{-- Indicador flotante de actualización de filtros --}}
    <div
        wire:loading.delay
        wire:target="year,month,resetFilters"
        class="fixed right-4 top-24 z-[9999] rounded-xl bg-gray-900 px-4 py-2 text-sm font-medium text-white shadow-lg dark:bg-slate-700"
    >
        Actualizando datos...
    </div>

    <livewire:public-interface.header />

    <main class="min-h-[calc(100vh-80px)]">
        <div id="page-content" class="page-transition mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="pt-9">
                <livewire:public-interface.global-filters />
            </div>

            {{ $slot }}
        </div>
    </main>

    <livewire:public-interface.footer />

    @livewireScripts
</body>
</html>

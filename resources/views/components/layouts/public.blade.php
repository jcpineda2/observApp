<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Aplicar tema antes de pintar la página para evitar flash --}}
    <script>
        (function () {
            const storageKey = 'observatorio-theme';
            const root = document.documentElement;

            function getSystemTheme() {
                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }

            function getSavedTheme() {
                try {
                    return localStorage.getItem(storageKey);
                } catch (_) {
                    return null;
                }
            }

            const savedTheme = getSavedTheme();
            const theme = savedTheme === 'dark' || savedTheme === 'light'
                ? savedTheme
                : getSystemTheme();

            root.classList.toggle('dark', theme === 'dark');
            root.setAttribute('data-theme', theme);
        })();
    </script>

    {{-- Navegación visual con wire:navigate --}}
    <script>
        document.addEventListener('livewire:navigated', () => {
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
    <div wire:loading.delay wire:target="year,month,resetFilters"
        class="fixed right-4 top-24 z-[9999] rounded-xl bg-gray-900 px-4 py-2 text-sm font-medium text-white shadow-lg dark:bg-slate-700">
        Actualizando datos...
    </div>

    <x-public.layout.header />

    <main class="min-h-[calc(100vh-80px)]">
        <div id="page-content" class="page-transition mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>

    <x-public.layout.footer />

    @livewireScripts
</body>
</html>

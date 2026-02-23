<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ $title ?? 'Observatorio Turístico - SENATUR' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700" rel="stylesheet"/>
</head>

<body class="bg-background-light text-slate-900 antialiased"
      style="font-family: 'Plus Jakarta Sans', sans-serif;">
<div class="min-h-screen">

    {{-- Header (sticky) --}}
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-slate-100">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="h-14 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    {{-- mobile menu button --}}
                    <button type="button"
                        class="lg:hidden inline-flex items-center justify-center rounded-lg p-2 hover:bg-slate-100"
                        x-on:click="$dispatch('toggle-sidebar')">
                        <span class="material-symbols-outlined">menu</span>
                    </button>

                    <div class="flex flex-col leading-none">
                        <span class="text-xs font-bold tracking-wide uppercase">SENATUR</span>
                        <span class="text-[11px] text-slate-500 font-medium">Observatorio Turístico</span>
                    </div>
                </div>

                <a href="{{ route('public.home') }}" class="inline-flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">travel_explore</span>
                    <span class="text-sm font-semibold hidden sm:block">Inicio</span>
                </a>
            </div>
        </div>

        {{-- Franja institucional --}}
        <div class="flex h-1 w-full">
            <div class="h-full w-1/4 bg-brand-red"></div>
            <div class="h-full w-1/4 bg-brand-green"></div>
            <div class="h-full w-1/4 bg-brand-blue"></div>
            <div class="h-full w-1/4 bg-brand-yellow"></div>
        </div>
    </header>

    {{-- Body: sidebar + content --}}
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6"
         x-data="{ sidebarOpen: false }"
         x-on:toggle-sidebar.window="sidebarOpen = !sidebarOpen">

        <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-6">

            {{-- Sidebar (desktop) / Drawer (mobile) --}}
            <aside
                class="lg:static lg:block"
                :class="sidebarOpen ? 'block' : 'hidden lg:block'">
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-3 sticky top-20">

                    <nav class="space-y-1 text-sm">
                        <a href="{{ route('public.home') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-slate-50">
                            <span class="material-symbols-outlined text-primary text-[20px]">home</span>
                            <span class="font-semibold">Principal</span>
                        </a>

                        <div class="pt-2">
                            <div class="px-3 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                                Tableros
                            </div>

                            <a href="{{ route('public.domestic') }}"
                               class="mt-1 flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-slate-50">
                                <span class="material-symbols-outlined text-orange-500 text-[20px]">tour</span>
                                <span>Turismo Interno</span>
                            </a>

                            <a href="{{ route('public.inbound') }}"
                               class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-slate-50">
                                <span class="material-symbols-outlined text-purple-500 text-[20px]">flight_land</span>
                                <span>Turismo Receptivo</span>
                            </a>

                            <a href="#"
                               class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-slate-50">
                                <span class="material-symbols-outlined text-teal-600 text-[20px]">flight</span>
                                <span>Conectividad</span>
                            </a>

                            <a href="#"
                               class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-slate-50">
                                <span class="material-symbols-outlined text-brand-blue text-[20px]">apartment</span>
                                <span>Prestadores</span>
                            </a>

                            <a href="#"
                               class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-slate-50">
                                <span class="material-symbols-outlined text-slate-600 text-[20px]">badge</span>
                                <span>Empleo Turístico</span>
                            </a>

                            <a href="#"
                               class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-slate-50">
                                <span class="material-symbols-outlined text-slate-600 text-[20px]">menu_book</span>
                                <span>Glosario</span>
                            </a>
                        </div>
                    </nav>

                </div>
            </aside>

            {{-- Main content --}}
            <main class="min-w-0">
                {{ $slot }}
            </main>

        </div>
    </div>

    <footer class="border-t border-slate-100 py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center text-xs text-slate-500">
            © {{ now()->year }} SENATUR - Gobierno del Paraguay
        </div>
    </footer>
</div>

@livewireScripts
</body>
</html>

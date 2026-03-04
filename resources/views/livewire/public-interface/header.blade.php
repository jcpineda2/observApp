<header
    x-data="{ open: false }"
    class="sticky top-0 z-50 w-full border-b border-white/10 bg-blue-800 text-white"
>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                {{-- Placeholder de logo: luego lo cambiamos por el SVG/imagen oficial --}}
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10 ring-1 ring-white/15">
                    <span class="text-sm font-bold tracking-wide">R</span>
                </div>

                <div class="leading-tight">
                    <div class="text-sm font-semibold uppercase tracking-wide">SENATUR</div>
                    <div class="text-[11px] text-white/80">Observatorio</div>
                </div>
            </a>

            {{-- Menú Desktop --}}
            <nav class="hidden items-center gap-6 md:flex">
                <a href="#principal" class="text-sm font-medium text-white/90 hover:text-white">Principal</a>
                <a href="#turismo-interno" class="text-sm font-medium text-white/90 hover:text-white">Turismo interno</a>
                <a href="#turismo-receptivo" class="text-sm font-medium text-white/90 hover:text-white">Turismo receptivo</a>
                <a href="#prestadores" class="text-sm font-medium text-white/90 hover:text-white">Prestadores</a>
                <a href="#alojamientos" class="text-sm font-medium text-white/90 hover:text-white">Alojamientos</a>
                <a href="#empleo" class="text-sm font-medium text-white/90 hover:text-white">Empleo</a>
                <a href="#conectividad" class="text-sm font-medium text-white/90 hover:text-white">Conectividad aérea</a>
            </nav>

            {{-- Botón hamburguesa --}}
            <button
                type="button"
                class="inline-flex items-center justify-center rounded-lg p-2 text-white/90 hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/30 md:hidden"
                @click="open = !open"
                :aria-expanded="open.toString()"
                aria-label="Abrir menú"
            >
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>

                <svg x-show="open" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Menú Mobile --}}
    <div x-show="open" x-cloak class="border-t border-white/10 bg-blue-800 md:hidden">
        <div class="mx-auto max-w-7xl px-4 py-3 sm:px-6 lg:px-8">
            <nav class="flex flex-col gap-2">
                <a @click="open=false" href="#principal" class="rounded-lg px-3 py-2 text-sm font-medium hover:bg-white/10">Principal</a>
                <a @click="open=false" href="#turismo-interno" class="rounded-lg px-3 py-2 text-sm font-medium hover:bg-white/10">Turismo interno</a>
                <a @click="open=false" href="#turismo-receptivo" class="rounded-lg px-3 py-2 text-sm font-medium hover:bg-white/10">Turismo receptivo</a>
                <a @click="open=false" href="#prestadores" class="rounded-lg px-3 py-2 text-sm font-medium hover:bg-white/10">Prestadores</a>
                <a @click="open=false" href="#alojamientos" class="rounded-lg px-3 py-2 text-sm font-medium hover:bg-white/10">Alojamientos</a>
                <a @click="open=false" href="#empleo" class="rounded-lg px-3 py-2 text-sm font-medium hover:bg-white/10">Empleo</a>
                <a @click="open=false" href="#conectividad" class="rounded-lg px-3 py-2 text-sm font-medium hover:bg-white/10">Conectividad aérea</a>
            </nav>
        </div>
    </div>
</header>

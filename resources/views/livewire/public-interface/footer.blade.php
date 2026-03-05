<footer class="mt-10 bg-slate-900 text-slate-200">
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid gap-10 md:grid-cols-3">

            {{-- Marca --}}
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    {{-- Logo placeholder (luego lo cambiamos por SVG/imagen) --}}
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 ring-1 ring-white/10">
                        <span class="text-sm font-bold tracking-wide">R</span>
                    </div>

                    <div class="leading-tight">
                        <div class="text-sm font-semibold uppercase tracking-wide">SENATUR</div>
                        <div class="text-xs text-slate-400">Observatorio</div>
                    </div>
                </div>

                <p class="text-sm text-slate-400">
                    Plataforma de información y estadísticas del sector turístico.
                </p>

                <p class="text-xs text-slate-500">
                    © {{ now()->year }} SENATUR. Todos los derechos reservados.
                </p>

                {{-- Redes (placeholders) --}}
                <div class="flex items-center gap-3 pt-2">
                    <a href="#" class="rounded-full p-2 text-slate-300 hover:bg-white/10 hover:text-white" aria-label="X">
                        {{-- X --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18.9 2H22l-6.8 7.8L23 22h-6.4l-5-6.6L5.8 22H2.7l7.3-8.4L1 2h6.5l4.6 6.1L18.9 2zm-1.1 18h1.7L7.1 3.9H5.3L17.8 20z"/>
                        </svg>
                    </a>

                    <a href="#" class="rounded-full p-2 text-slate-300 hover:bg-white/10 hover:text-white" aria-label="Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M13.5 22v-8h2.7l.4-3H13.5V9.2c0-.9.3-1.6 1.7-1.6H16.7V5c-.3 0-1.4-.1-2.7-.1-2.7 0-4.5 1.6-4.5 4.6V11H7v3h2.5v8h4z"/>
                        </svg>
                    </a>

                    <a href="#" class="rounded-full p-2 text-slate-300 hover:bg-white/10 hover:text-white" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm10 2H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3zm-5 4.5A5.5 5.5 0 1 1 6.5 14 5.5 5.5 0 0 1 12 8.5zm0 2A3.5 3.5 0 1 0 15.5 14 3.5 3.5 0 0 0 12 10.5zM18 6.8a1 1 0 1 1-1 1 1 1 0 0 1 1-1z"/>
                        </svg>
                    </a>

                    <a href="#" class="rounded-full p-2 text-slate-300 hover:bg-white/10 hover:text-white" aria-label="YouTube">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M21.6 7.2a3 3 0 0 0-2.1-2.1C17.7 4.6 12 4.6 12 4.6s-5.7 0-7.5.5A3 3 0 0 0 2.4 7.2 31.7 31.7 0 0 0 2 12a31.7 31.7 0 0 0 .4 4.8 3 3 0 0 0 2.1 2.1c1.8.5 7.5.5 7.5.5s5.7 0 7.5-.5a3 3 0 0 0 2.1-2.1A31.7 31.7 0 0 0 22 12a31.7 31.7 0 0 0-.4-4.8zM10 15.5v-7l6 3.5-6 3.5z"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Información --}}
            {{-- <div>
                <h3 class="text-sm font-semibold text-white">Información</h3>
                <ul class="mt-4 space-y-2 text-sm">
                    <li><a href="#" class="text-slate-300 hover:text-white">Términos y Condiciones</a></li>
                    <li><a href="#" class="text-slate-300 hover:text-white">Reclamos</a></li>
                    <li><a href="#" class="text-slate-300 hover:text-white">Ayuda</a></li>
                    <li>
                        <a href="{{ url('/admin') }}"
                           class="text-slate-300 hover:text-white">
                            Acceso al Portal Administrador
                        </a>
                    </li>
                </ul>
            </div> --}}

            {{-- Contactos --}}
            <div class="">
                <h3 class="text-sm font-semibold text-white">Contactos</h3>
                <ul class="mt-4 space-y-2 text-sm text-slate-300">
                    <li>
                        <span class="text-slate-400">Dirección:</span>
                        Palma 468 e/ Alberdi y 14 de Mayo
                    </li>
                    <li>
                        <span class="text-slate-400">Teléfono:</span>
                        +595 21 494 110
                    </li>
                    <li>
                        <span class="text-slate-400">E-mail:</span>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    {{-- Barra inferior --}}
    <div class="border-t border-white/10">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 text-xs text-slate-500 sm:px-6 lg:px-8">
            <span>Hecho con Laravel + Livewire</span>
            <a href="#top" class="hover:text-white">Volver arriba ↑</a>
        </div>
    </div>
</footer>

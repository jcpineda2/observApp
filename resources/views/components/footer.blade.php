<footer class="mt-14 bg-[var(--color-app-text)] pt-16 pb-8 text-white dark:bg-[#020617]">
    <div class="ui-shell">
        <div class="grid gap-10 md:grid-cols-3">
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 ring-1 ring-white/10">
                        <span class="text-sm font-bold tracking-wide">S</span>
                    </div>

                    <div class="leading-tight">
                        <div class="text-sm font-semibold uppercase tracking-wide">SENATUR</div>
                        <div class="text-xs text-white/70">Observatorio Turístico</div>
                    </div>
                </div>

                <p class="text-sm text-white/70">
                    Plataforma de información y estadísticas del sector turístico.
                </p>

                <p class="text-xs text-white/50">
                    © {{ now()->year }} SENATUR. Todos los derechos reservados.
                </p>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-white">Información</h3>
                <ul class="mt-4 space-y-2 text-sm text-white/70">
                    <li><a href="#" class="hover:text-white">Política de privacidad</a></li>
                    <li><a href="#" class="hover:text-white">Términos y condiciones</a></li>
                    <li><a href="#" class="hover:text-white">Ayuda</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-white">Síguenos</h3>
                <div class="mt-4 flex items-center gap-3">
                    <a href="#" class="rounded-full p-2 text-white/70 hover:bg-white/10 hover:text-white">Facebook</a>
                    <a href="#" class="rounded-full p-2 text-white/70 hover:bg-white/10 hover:text-white">Instagram</a>
                    <a href="#" class="rounded-full p-2 text-white/70 hover:bg-white/10 hover:text-white">YouTube</a>
                </div>
            </div>
        </div>
    </div>
</footer>

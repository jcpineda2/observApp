<div class="space-y-6">
    <section class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <div class="flex items-start justify-between gap-6">
            <div>
                <span class="text-xs font-semibold tracking-wider text-primary uppercase">Indicadores</span>
                <h1 class="text-2xl font-bold mt-1">Turismo Interno</h1>
                <p class="text-sm text-slate-500 mt-2">
                    Movilidad turística de residentes dentro del país. :contentReference[oaicite:10]{index=10}
                </p>
            </div>
        </div>

        {{-- Filtros (Opción B: select de año dentro del tablero) --}}
        <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-3">
            <div>
                <label class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Año</label>
                <select wire:model.live="yearId" class="mt-1 w-full rounded-xl border-slate-200">
                    @foreach ($years as $y)
                        <option value="{{ $y->id }}">{{ $y->year }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Mes</label>
                <select wire:model.live="monthId" class="mt-1 w-full rounded-xl border-slate-200">
                    <option value="">Todos</option>
                    @foreach ($months as $m)
                        <option value="{{ $m->id }}">{{ $m->month }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Departamento
                    destino</label>
                <select wire:model.live="departmentId" class="mt-1 w-full rounded-xl border-slate-200">
                    <option value="">Todos</option>
                    @foreach ($departments as $d)
                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Motivo</label>
                <select wire:model.live="reasonId" class="mt-1 w-full rounded-xl border-slate-200">
                    <option value="">Todos</option>
                    @foreach ($reasons as $r)
                        <option value="{{ $r->id }}">{{ $r->description }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </section>

    {{-- Cards de indicadores principales (PDF) --}}
    <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Turistas internos</p>
            <p class="text-3xl font-bold mt-2">{{ number_format((int) $totals->tourist_quantity) }}</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Gasto turístico interno</p>
            <p class="text-3xl font-bold mt-2">{{ number_format((float) $totals->total_spend, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Estadía promedio</p>
            <p class="text-3xl font-bold mt-2">{{ number_format((float) $totals->average_stay, 2) }}</p>
        </div>
    </section>

    {{-- Ranking (segmentación por depto destino) --}}
    <section class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h2 class="text-lg font-bold">Ranking por departamento destino</h2>
        <p class="text-sm text-slate-500 mt-1">
            Segmentación por departamento destino. :contentReference[oaicite:11]{index=11}
        </p>

        <div class="mt-4 divide-y divide-slate-100">
            @forelse($topDepartments as $row)
                <div class="py-3 flex items-center justify-between">
                    <span class="text-sm font-medium text-slate-700">
                        {{ $row->department?->name ?? 'N/A' }}
                    </span>
                    <span class="text-sm font-bold">{{ number_format((int) $row->total) }}</span>
                </div>
            @empty
                <p class="text-sm text-slate-500">No hay datos para los filtros seleccionados.</p>
            @endforelse
        </div>
    </section>

    <section class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h2 class="text-lg font-bold">Apertura por motivo de viaje</h2>
        <p class="text-sm text-slate-500 mt-1">
            Segmentación por motivo (ocio, negocios, visitas, etc.).
        </p>

        <div class="mt-4 divide-y divide-slate-100">
            @forelse($byReason as $row)
                <div class="py-3 flex items-center justify-between">
                    <span class="text-sm text-slate-700">
                        {{ $row->travelReason?->description ?? 'N/A' }}
                    </span>
                    <span class="text-sm font-bold">{{ number_format((int) $row->total) }}</span>
                </div>
            @empty
                <p class="text-sm text-slate-500">No hay datos para esta apertura.</p>
            @endforelse
        </div>
    </section>

    <section class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h2 class="text-lg font-bold">Apertura por mes</h2>
        <p class="text-sm text-slate-500 mt-1">
            Base para gráfico de evolución mensual.
        </p>

        <div class="mt-4 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
            @forelse($byMonth as $row)
                <div class="rounded-xl border border-slate-100 p-3">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        {{ $row->month?->month ?? 'Mes' }}
                    </p>
                    <p class="text-lg font-bold mt-1">{{ number_format((int) $row->total) }}</p>
                </div>
            @empty
                <p class="text-sm text-slate-500">No hay datos para mostrar por mes.</p>
            @endforelse
        </div>
    </section>
</div>

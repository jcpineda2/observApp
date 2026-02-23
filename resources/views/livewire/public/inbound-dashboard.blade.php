<div class="space-y-6">
    {{-- Header + Filtros --}}
    <section class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <div class="flex items-start justify-between gap-6">
            <div>
                <span class="text-xs font-semibold tracking-wider text-primary uppercase">Indicadores</span>
                <h1 class="text-2xl font-bold mt-1">Turismo Receptivo</h1>
                <p class="text-sm text-slate-500 mt-2">
                    Turistas internacionales que ingresan al país.
                </p>
                <p class="text-xs text-slate-400 mt-1">
                    Indicadores y aperturas según el esquema del observatorio. :contentReference[oaicite:3]{index=3}
                </p>
            </div>
        </div>

        {{-- Filtros (Opción B: select año aquí) --}}
        <div class="mt-6 grid grid-cols-1 md:grid-cols-5 gap-3">
            <div>
                <label class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Año</label>
                <select wire:model.live="yearId" class="mt-1 w-full rounded-xl border-slate-200">
                    @foreach($years as $y)
                        <option value="{{ $y->id }}">{{ $y->year }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Mes</label>
                <select wire:model.live="monthId" class="mt-1 w-full rounded-xl border-slate-200">
                    <option value="">Todos</option>
                    @foreach($months as $m)
                        <option value="{{ $m->id }}">{{ $m->month }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-[11px] font-bold uppercase tracking-wider text-slate-500">País residencia</label>
                <select wire:model.live="countryId" class="mt-1 w-full rounded-xl border-slate-200">
                    <option value="">Todos</option>
                    @foreach($countries as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Vía de ingreso</label>
                <select wire:model.live="entryModeId" class="mt-1 w-full rounded-xl border-slate-200">
                    <option value="">Todas</option>
                    @foreach($entryModes as $e)
                        <option value="{{ $e->id }}">{{ $e->description }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Motivo</label>
                <select wire:model.live="reasonId" class="mt-1 w-full rounded-xl border-slate-200">
                    <option value="">Todos</option>
                    @foreach($reasons as $r)
                        <option value="{{ $r->id }}">{{ $r->description }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mt-4 flex items-center gap-2 text-xs text-slate-400">
            <span class="material-symbols-outlined text-[18px]">info</span>
            <span>
                Estos filtros corresponden a las aperturas: país, vía, motivo y mes. :contentReference[oaicite:4]{index=4}
            </span>
        </div>
    </section>

    {{-- Indicadores clave (PDF) --}}
    <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Llegadas turistas</p>
            <p class="text-3xl font-bold mt-2">{{ number_format((int)$totals->tourist_arrivals) }}</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Excursionistas</p>
            <p class="text-3xl font-bold mt-2">{{ number_format((int)$totals->excursionist_arrivals) }}</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Ingresos divisas</p>
            <p class="text-2xl font-bold mt-2">{{ number_format((float)$totals->foreign_exchange_revenue, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Gasto promedio</p>
            <p class="text-2xl font-bold mt-2">{{ number_format((float)$totals->average_spend, 2, ',', '.') }}</p>
            <p class="text-xs text-slate-400 mt-1">Dato fijo en el esquema. :contentReference[oaicite:5]{index=5}</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Estadía promedio</p>
            <p class="text-2xl font-bold mt-2">{{ number_format((float)$totals->average_stay, 2, ',', '.') }}</p>
            <p class="text-xs text-slate-400 mt-1">Dato fijo en el esquema. :contentReference[oaicite:6]{index=6}</p>
        </div>
    </section>

    {{-- Visualización: Ranking mercados emisores (Top países) --}}
    <section class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h2 class="text-lg font-bold">Ranking de mercados emisores</h2>
            <p class="text-sm text-slate-500 mt-1">
                Top países por llegadas de turistas. :contentReference[oaicite:7]{index=7}
            </p>

            <div class="mt-4 divide-y divide-slate-100">
                @forelse($topCountries as $row)
                    <div class="py-3 flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-700">
                            {{ $row->country?->name ?? 'N/A' }}
                        </span>
                        <span class="text-sm font-bold">{{ number_format((int)$row->total) }}</span>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">No hay datos para los filtros seleccionados.</p>
                @endforelse
            </div>
        </div>

        {{-- Aperturas: vía y motivo --}}
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <h2 class="text-lg font-bold">Apertura por vía de ingreso</h2>
                <p class="text-sm text-slate-500 mt-1">
                    Aérea / Terrestre / Fluvial-marítima (según configuración). :contentReference[oaicite:8]{index=8}
                </p>

                <div class="mt-4 divide-y divide-slate-100">
                    @forelse($byEntryMode as $row)
                        <div class="py-3 flex items-center justify-between">
                            <span class="text-sm text-slate-700">
                                {{ $row->entryMode?->description ?? 'N/A' }}
                            </span>
                            <span class="text-sm font-bold">{{ number_format((int)$row->total) }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">No hay datos para esta apertura.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <h2 class="text-lg font-bold">Apertura por motivo de viaje</h2>
                <p class="text-sm text-slate-500 mt-1">
                    Ocio, negocios, visitas, deportes, etc. :contentReference[oaicite:9]{index=9}
                </p>

                <div class="mt-4 divide-y divide-slate-100">
                    @forelse($byReason as $row)
                        <div class="py-3 flex items-center justify-between">
                            <span class="text-sm text-slate-700">
                                {{ $row->travelReason?->description ?? 'N/A' }}
                            </span>
                            <span class="text-sm font-bold">{{ number_format((int)$row->total) }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">No hay datos para esta apertura.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    {{-- Apertura por mes (base para “evolución” después) --}}
    <section class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h2 class="text-lg font-bold">Apertura por mes</h2>
        <p class="text-sm text-slate-500 mt-1">
            Base para evolución interanual y gráficos. :contentReference[oaicite:10]{index=10}
        </p>

        <div class="mt-4 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
            @forelse($byMonth as $row)
                <div class="rounded-xl border border-slate-100 p-3">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        {{ $row->month?->month ?? 'Mes' }}
                    </p>
                    <p class="text-lg font-bold mt-1">{{ number_format((int)$row->total) }}</p>
                </div>
            @empty
                <p class="text-sm text-slate-500">No hay datos para mostrar por mes.</p>
            @endforelse
        </div>
    </section>
</div>

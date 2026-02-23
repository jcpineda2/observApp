<div>
<section class="px-4 pt-6 pb-4">
    <div class="flex items-start justify-between gap-4">
        <div>
            <span class="text-xs font-semibold tracking-wider text-primary uppercase">Indicadores</span>
            <h2 class="text-2xl font-bold text-slate-900 leading-tight">Turismo Interno</h2>
            <p class="text-slate-500 text-sm mt-1">Movimiento turístico nacional y destinos preferidos.</p>
        </div>

        <a href="{{ route('public.home') }}" class="text-sm font-semibold text-primary hover:underline">
            Volver
        </a>
    </div>

    <div class="mt-4 bg-white rounded-xl border border-slate-100 p-4 space-y-3">
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Año</label>
                <select wire:model.live="yearId" class="mt-1 w-full rounded-lg border-slate-200 text-sm">
                    @foreach($years as $y)
                        <option value="{{ $y->id }}">{{ $y->year }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Mes</label>
                <select wire:model.live="monthId" class="mt-1 w-full rounded-lg border-slate-200 text-sm">
                    <option value="">Todos</option>
                    @foreach($months as $m)
                        <option value="{{ $m->id }}">{{ $m->month }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Departamento destino</label>
            <select wire:model.live="departmentId" class="mt-1 w-full rounded-lg border-slate-200 text-sm">
                <option value="">Todos</option>
                @foreach($departments as $d)
                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</section>

<section class="px-4 pb-6">
    <div class="grid grid-cols-2 gap-3">
        <div class="bg-white rounded-xl border border-slate-100 p-4">
            <p class="text-[10px] uppercase tracking-wider text-slate-500 font-semibold">Turistas</p>
            <p class="text-2xl font-bold mt-1">{{ number_format((int)$totals->tourist_quantity) }}</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-100 p-4">
            <p class="text-[10px] uppercase tracking-wider text-slate-500 font-semibold">Gasto total</p>
            <p class="text-xl font-bold mt-1">
                {{ number_format((float)$totals->total_spend, 0, ',', '.') }}
            </p>
        </div>

        <div class="bg-white rounded-xl border border-slate-100 p-4 col-span-2">
            <p class="text-[10px] uppercase tracking-wider text-slate-500 font-semibold">Estadía promedio</p>
            <p class="text-xl font-bold mt-1">{{ number_format((float)$totals->average_stay, 2) }}</p>
        </div>
    </div>

    <div class="mt-4 bg-white rounded-xl border border-slate-100 p-4">
        <h3 class="text-sm font-bold text-slate-900">Top 5 departamentos destino</h3>

        <div class="mt-3 space-y-2">
            @forelse($topDepartments as $row)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-700 truncate">
                        {{ $row->department?->name ?? 'N/A' }}
                    </span>
                    <span class="text-sm font-bold text-slate-900">
                        {{ number_format((int)$row->total) }}
                    </span>
                </div>
            @empty
                <p class="text-sm text-slate-500">No hay datos cargados para este filtro.</p>
            @endforelse
        </div>
    </div>
</section>
</div>

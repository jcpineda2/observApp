<div>
<section class="space-y-6">
    <header class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold">Prestadores de Servicios Turísticos</h1>
                <p class="text-sm text-slate-600">
                    Total, altas/bajas, variación interanual y porcentaje de formalización.
                </p>
            </div>
        </div>

        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div>
                <label class="text-xs font-semibold text-slate-600">Año</label>
                <select wire:model.live="yearId" class="mt-1 w-full rounded-xl border-slate-200">
                    <option value="">Todos</option>
                    @foreach ($this->years as $y)
                        <option value="{{ $y->id }}">{{ $y->year }}</option>
                    @endforeach
                </select>
                @error('yearId') <div class="mt-1 text-xs text-red-600">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-600">Mes</label>
                <select wire:model.live="monthId" class="mt-1 w-full rounded-xl border-slate-200">
                    <option value="">Todos</option>
                    @foreach ($this->months as $m)
                        <option value="{{ $m->id }}">{{ $m->name }}</option>
                    @endforeach
                </select>
                @error('monthId') <div class="mt-1 text-xs text-red-600">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-600">Rubro</label>
                <select wire:model.live="serviceSectorId" class="mt-1 w-full rounded-xl border-slate-200">
                    <option value="">Todos</option>
                    @foreach ($this->serviceSectors as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </select>
                @error('serviceSectorId') <div class="mt-1 text-xs text-red-600">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-600">Departamento</label>
                <select wire:model.live="stateId" class="mt-1 w-full rounded-xl border-slate-200">
                    <option value="">Todos</option>
                    @foreach ($this->states as $st)
                        <option value="{{ $st->id }}">{{ $st->name }}</option>
                    @endforeach
                </select>
                @error('stateId') <div class="mt-1 text-xs text-red-600">{{ $message }}</div> @enderror
            </div>
        </div>
    </header>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
            <div class="text-xs text-slate-500">Total PST</div>
            <div class="mt-1 text-2xl font-semibold">{{ number_format($this->kpis['total']) }}</div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
            <div class="text-xs text-slate-500">Altas</div>
            <div class="mt-1 text-2xl font-semibold">{{ number_format($this->kpis['registrations']) }}</div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
            <div class="text-xs text-slate-500">Bajas</div>
            <div class="mt-1 text-2xl font-semibold">{{ number_format($this->kpis['cancellations']) }}</div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
            <div class="text-xs text-slate-500">% Formalización</div>
            <div class="mt-1 text-2xl font-semibold text-primary">
                {{ $this->kpis['formalization_rate'] }}%
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
            <div class="text-xs text-slate-500">Variación interanual</div>
            <div class="mt-1 text-2xl font-semibold">
                @if (is_null($this->kpis['yoy_variation']))
                    —
                @else
                    {{ $this->kpis['yoy_variation'] }}%
                @endif
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
        <div class="flex items-center justify-between">
            <div class="text-sm font-semibold">Altas y bajas por período</div>
            <div class="text-xs text-slate-500">Siguiente paso</div>
        </div>
        <div class="mt-3 h-72 rounded-xl bg-background-light border border-slate-100"></div>
    </div>
</section>
</div>

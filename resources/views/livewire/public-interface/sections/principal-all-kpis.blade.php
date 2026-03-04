<div class="space-y-8">
    @foreach($groups as $groupTitle => $items)
        <section class="space-y-3">
            <div class="flex items-end justify-between">
                <h2 class="text-sm font-semibold text-gray-900">{{ $groupTitle }}</h2>
                @if(in_array($groupTitle, ['Turismo receptivo','Turismo interno','Conectividad aérea','Prestadores'], true))
                    <span class="text-xs text-gray-500">
                        @if($year) Año: {{ \App\Models\Year::find($year)?->year ?? '—' }} @endif
                        @if($month) · Mes: {{ \App\Models\Month::find($month)?->month ?? '—' }} @endif
                    </span>
                @endif
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($items as $kpi)
                    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
                        <div class="text-xs font-medium text-gray-600">
                            {{ $kpi['title'] }}
                        </div>

                        <div class="mt-2 text-3xl font-extrabold text-gray-900">
                            {{ $kpi['value'] }}
                        </div>

                        @if(!empty($kpi['subtitle']))
                            <div class="mt-1 text-xs text-gray-500">
                                {{ $kpi['subtitle'] }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
    @endforeach
</div>

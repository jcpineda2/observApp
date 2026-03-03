{{-- @props([
    'title' => '',
    'value' => '',
    'subtitle' => null,
    'trend' => null,
    'trendDirection' => null, // up | down | null
]) --}}


<div class="group relative overflow-hidden rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200 transition hover:shadow-md">

    {{-- Accent decorativo --}}
    <div class="absolute inset-x-0 top-0 h-1 bg-blue-800"></div>

    <div class="space-y-3">
        <div class="text-sm font-medium text-gray-500">
            {{ $title }}
        </div>

        <div class="text-3xl font-bold tracking-tight text-gray-900">
            {{ $value }}
        </div>

        @if($subtitle)
            <div class="text-xs text-gray-500">
                {{ $subtitle }}
            </div>
        @endif

        @if($trend)
            <div class="flex items-center gap-1 text-xs font-medium
                @if($trendDirection === 'up') text-emerald-600
                @elseif($trendDirection === 'down') text-rose-600
                @else text-gray-500
                @endif
            ">
                @if($trendDirection === 'up')
                    ↑
                @elseif($trendDirection === 'down')
                    ↓
                @endif

                <span>{{ $trend }}</span>
            </div>
        @endif
    </div>

</div>
